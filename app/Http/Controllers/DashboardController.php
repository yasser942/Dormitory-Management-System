<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Meal;
use App\Models\Room;
use App\Models\Sport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public  function index(){
        $totalStudents = User::where('role_id', 2)->count();
        $totalEmployees = User::where('role_id', 3)->count();
        $vacantRooms = Room::where('status', 'vacant')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $totalRooms = Room::all()->count();
        $totalBooks = Book::all()->count();
        $totalMeals = Meal::all()->count();
        $totalSports = Sport::all()->count();



        //////////////////////////////////////////////////////////////////

        // Retrieve the user registration data for the current month
        $visitorDataCurrentMonth = User::whereMonth('created_at', now()->month)
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('d');
            });

        // Retrieve the user registration data for the previous month
        $visitorDataPreviousMonth = User::whereMonth('created_at', now()->subMonth()->month)
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('d');
            });

        $visitorCountCurrentMonth = [];
        $visitorCountPreviousMonth = [];

        foreach (range(1, now()->daysInMonth) as $day) {
            $dayString = str_pad($day, 2, '0', STR_PAD_LEFT);

            // Check if the date has data in $visitorDataCurrentMonth, otherwise set count to 0
            if ($visitorDataCurrentMonth->has($dayString)) {
                $visitorCountCurrentMonth[$day] = $visitorDataCurrentMonth->get($dayString)->count();
            } else {
                $visitorCountCurrentMonth[$day] = 0;
            }

            // Check if the date has data in $visitorDataPreviousMonth, otherwise set count to 0
            if ($visitorDataPreviousMonth->has($dayString)) {
                $visitorCountPreviousMonth[$day] = $visitorDataPreviousMonth->get($dayString)->count();
            } else {
                $visitorCountPreviousMonth[$day] = 0;
            }
        }

        $visitorCountValuesCurrentMonth = array_values($visitorCountCurrentMonth);
        $visitorCountValuesPreviousMonth = array_values($visitorCountPreviousMonth);
        //////////////////////////////////////////////////////////////////






        return view('admin.index',
            compact('totalStudents',
                'totalEmployees','vacantRooms','totalRooms',
                'totalBooks',
                'totalMeals','totalSports',
                'occupiedRooms','visitorCountValuesCurrentMonth',
                'visitorCountValuesPreviousMonth' ));
    }


    public function changeTheme (Request $request){
        $user = User::find(auth()->user()->id);
        $user->theme = $request->theme;
        $user->save();
        return redirect()->back();
    }

    public function studentDashBoard (){
        if (auth()->user()->role_id == 2){
            return view('student.dashboard');
        }
        return redirect()->back();
    }
    public function employeeDashBoard(){

        if (auth()->user()->role_id == 3 &&auth()->user()->profileable->job_title=='librarian'){
            $totalBooks = Book::all()->count();
            $borrowedBooksCount = DB::table('book_user')->count();
            $distinctStudentCount = $distinctStudentCount = Book::join('book_user', 'books.id', '=', 'book_user.book_id')
                ->groupBy('book_user.user_id')
                ->selectRaw('count(distinct book_user.user_id) as student_count')
                ->pluck('student_count')
                ->first();



            $borrowedBooksCurrentMonth = Book::with('users')
                ->whereHas('users', function ($query) {
                    $query->whereMonth('book_user.created_at', now()->month);
                })
                ->get()
                ->groupBy(function ($book) {
                    return optional($book->users->first()->pivot->created_at)->format('d');
                });



            // Retrieve the books borrowed data for the previous month
            $borrowedBooksPreviousMonth = Book::with('users')
                ->whereHas('users', function ($query) {
                    $query->whereMonth('book_user.created_at', now()->subMonth()->month);
                })
                ->get()
                ->groupBy(function ($book) {
                    return optional($book->users->first()->pivot->created_at)->format('d');
                });






            $borrowedBooksCountCurrentMonth = [];
            $borrowedBooksCountPreviousMonth = [];

            foreach (range(1, now()->daysInMonth) as $day) {
                $dayString = str_pad($day, 2, '0', STR_PAD_LEFT);

                // Check if the date has data in $borrowedBooksCurrentMonth, otherwise set count to 0
                if ($borrowedBooksCurrentMonth->has($dayString)) {
                    $borrowedBooksCountCurrentMonth[$day] = $borrowedBooksCurrentMonth->get($dayString)->count();
                } else {
                    $borrowedBooksCountCurrentMonth[$day] = 0;
                }

                // Check if the date has data in $borrowedBooksPreviousMonth, otherwise set count to 0
                if ($borrowedBooksPreviousMonth->has($dayString)) {
                    $borrowedBooksCountPreviousMonth[$day] = $borrowedBooksPreviousMonth->get($dayString)->count();
                } else {
                    $borrowedBooksCountPreviousMonth[$day] = 0;
                }
            }


            $borrowedBooksCountValuesCurrentMonth = array_values($borrowedBooksCountCurrentMonth);
            $borrowedBooksCountValuesPreviousMonth = array_values($borrowedBooksCountPreviousMonth);

            return view('employee.librarian.dashboard'
            ,compact('totalBooks','borrowedBooksCountValuesCurrentMonth',
                    'borrowedBooksCount',
                    'distinctStudentCount',
                    'borrowedBooksCountValuesPreviousMonth'));
        }
        if (auth()->user()->role_id == 3 &&auth()->user()->profileable->job_title=='trainer'){
            return view('employee.trainer.dashboard');
        }
        if (auth()->user()->role_id == 3 &&auth()->user()->profileable->job_title=='chief'){
            return view('employee.chief.dashboard');
        }
        return redirect()->back();
    }
}
