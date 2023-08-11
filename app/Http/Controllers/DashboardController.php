<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public  function index(){
        $totalStudents = User::where('role_id', 2)->count();
        $totalEmployees = User::where('role_id', 3)->count();
        $vacantRooms = Room::where('status', 'vacant')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        //////////////////////////////////////////////////////////////////


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




        return view('admin.index', compact('totalStudents', 'totalEmployees','vacantRooms','occupiedRooms','visitorCountValuesCurrentMonth','visitorCountValuesPreviousMonth' ));
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
            return view('employee.librarian.dashboard');
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
