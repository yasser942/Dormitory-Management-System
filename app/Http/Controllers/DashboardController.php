<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public  function index(){
        $totalStudents = User::where('role_id', 2)->count();
        $totalEmployees = User::where('role_id', 3)->count();
        $vacantRooms = Room::where('status', 'vacant')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();



        return view('admin.index', compact('totalStudents', 'totalEmployees','vacantRooms','occupiedRooms'));
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
