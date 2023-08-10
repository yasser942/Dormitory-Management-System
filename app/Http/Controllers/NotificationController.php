<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = auth()->user()->unReadNotifications()->paginate(3);
        return view('notification.index', compact('notifications'));
    }

    public function push(){
        return view('notification.push');
    }
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }


    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }
    public function notify(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'message' => 'required',
            'target' => 'required',
        ]);
        if ($data['target'] == 'all') {
            Notification::send(User::all(), new PushNotification($data['title'], $data['message']));
        }
        if ($data['target'] == 'students') {
            Notification::send(User::where('role_id', 2)->get(), new PushNotification($data['title'], $data['message']));
        }
        if ($data['target'] == 'employees') {
            Notification::send(User::where('role_id', 3)->get(), new PushNotification($data['title'], $data['message']));
        }
        /*
        if ($data['target'] == 'librarians') {

            $librarians = User::with(['profileable' => function ($query) {
                $query->select( 'job_title'); // Select the columns you need from the Employee table
            }])
                ->where('role_id', 3)
                ->where('profileable_type', 'App\Models\EmployeeProfile')
                ->get();

            Notification::send($librarians, new PushNotification($data['message'], $data['title']));
        }
        if ($data['target'] == 'trainers') {

            $trainers = User::with(['profileable' => function ($query) {
                $query->select( 'job_title'); // Select the columns you need from the Employee table
            }])
                ->where('role_id', 3)
                ->where('profileable_type', 'App\Models\EmployeeProfile')
                ->get();

            Notification::send($trainers, new PushNotification($data['message'], $data['title']));
        }
        if ($data['target'] == 'chiefs') {

            $chiefs = User::with(['profileable' => function ($query) {
                $query->select( 'job_title',); // Select the columns you need from the Employee table
            }])
                ->where('role_id', 3)
                ->where('profileable_type', 'App\Models\EmployeeProfile')

                ->get();

            Notification::send($chiefs, new PushNotification($data['message'], $data['title']));
        }

*/
        return redirect()->back()->with('success', 'Notification sent successfully');
    }



}
