<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Route::middleware('auth')->group(function () {


    Route::get('notifications', [NotificationController::class,'index'])->name('notifications.index');
    Route::get('markAllAsRead', [NotificationController::class,'markAllAsRead'])->name('markAllAsRead');
    Route::get('markAsRead/{notificationId}', [NotificationController::class,'markAsRead'])->name('markAsRead');
    Route::post('notify', [NotificationController::class,'notify'])->name('notify');

    Route::group(['middleware'=> 'role:student','prefix'=>'student'],function (){
        Route::get('/dashboard', [DashboardController::class, 'studentDashBoard'])->name('student.dashboard');
        Route::get('books', [LibraryController::class, 'index'])->name('student.books.index');
        Route::get('books/{book}/borrow', [LibraryController::class, 'borrowForm'])->name('student.books.borrow-form');
        Route::post('books/{book}/borrow', [LibraryController::class, 'borrow'])->name('student.books.borrow');
        Route::post('books/{book}/return', [LibraryController::class, 'return'])->name('student.books.return');

        Route::get('sports', [GymController::class, 'index'])->name('student.sports.index');
        Route::get('sports/{sport}/register', [GymController::class, 'registerForm'])->name('student.sports.register-form');
        Route::post('sports/{sport}/register', [GymController::class, 'register'])->name('student.sports.register');

        Route::get('meals', [KitchenController::class, 'index'])->name('student.meals.index');
        Route::post('/meals/{meal}/buy', [KitchenController::class, 'buyMeal'])->name('meals.buy');


    });
    Route::group(['middleware'=> 'role:employee','prefix'=>'employee'],function (){
        Route::get('/dashboard', [DashboardController::class, 'employeeDashBoard'])->name('employee.dashboard');

        Route::group(['middleware'=>'job_title:employee,librarian'],function (){
            Route::get('books-list', [LibraryController::class, 'index2'])->name('employee.books.index2');
            Route::get('members-list', [LibraryController::class, 'membersList'])->name('employee.members-list');
            Route::get('{user}/member-details', [LibraryController::class, 'memberDetails'])->name('employee.member-details');
            Route:: resource('library',    LibraryController::class);
        });

        Route::group(['middleware'=>'job_title:employee,trainer'],function (){
            Route::get('members-list', [GymController::class, 'membersList'])->name('employee.members-list');
            Route::get('{user}/member-details', [GymController::class, 'memberDetails'])->name('employee.member-details');
            Route::post('/sports/{sport}/users/{user}/unregister', [GymController::class, 'unregisterUserFromSport'])
                ->name('employee.users.unregister');


            Route:: resource('gym',    GymController::class);
        });
        Route::group(['middleware'=>'job_title:employee,chief'],function (){
            Route::get('members-list', [KitchenController::class, 'membersList'])->name('employee.members-list');
            Route::get('{user}/member-details', [KitchenController::class, 'memberDetails'])->name('employee.member-details');
            Route:: resource('kitchen',    KitchenController::class);
        });


    });
    Route::group(['middleware'=> 'role:admin'],function (){
        Route::get('push', [NotificationController::class,'push'])->name('notifications.push');
        Route::group([ 'prefix'=>'fee','middleware' => 'auth'],function (){
            Route::post('/{id}/assign-room-fee', [FeeController::class, 'calculateAndAssignRoomFee'])->name('fee.assign-room-fee');
        });

        Route::group([ 'prefix'=>'room','middleware' => 'auth'],function (){
            Route:: resource('rooms',    RoomController::class);
            Route::put('/rooms/{id}/toggle-status', [RoomController::class, 'toggleStatus'])->name('rooms.toggle-status');
        });

        Route::group([ 'prefix'=>'student','middleware' => 'auth'],function (){
            Route:: resource('students',    StudentController::class);
            Route::put('/students/{id}/toggle-status', [StudentController::class, 'toggleStatus'])->name('students.toggle-status');
            Route::get('/students/{id}/assign-room', [StudentController::class, 'assignRoomForm'])->name('students.assign-room');
            Route::post('/students/{id}/assign-room', [StudentController::class, 'assignStudentToRoom'])->name('students.assign_room');
        });
        Route::group([ 'prefix'=>'employee','middleware' => 'auth'],function (){
            Route:: resource('employees',    EmployeeController::class);
            Route::put('/employees/{id}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');
        });


        Route::group([ 'prefix'=>'book','middleware' => 'auth'],function (){
            Route::get('books-list', [LibraryController::class, 'index2'])->name('books.index2');
            Route::get('members-list', [LibraryController::class, 'membersList'])->name('books.members-list');
            Route::get('{user}/member-details', [LibraryController::class, 'memberDetails'])->name('books.member-details');
            Route:: resource('books',    LibraryController::class);
            // Route::put('/books/{id}/toggle-status', [RoomController::class, 'toggleStatus'])->name('rooms.toggle-status');
        });

        Route::group([ 'prefix'=>'sport','middleware' => 'auth'],function (){

            Route::get('members-list', [GymController::class, 'membersList'])->name('sports.members-list');
            Route::get('{user}/member-details', [GymController::class, 'memberDetails'])->name('sports.member-details');
            Route::post('/sports/{sport}/users/{user}/unregister', [GymController::class, 'unregisterUserFromSport'])
                ->name('sports.users.unregister');


            Route:: resource('sports',    GymController::class);
        });
        Route::group([ 'prefix'=>'meal','middleware' => 'auth'],function (){
            Route::get('members-list', [KitchenController::class, 'membersList'])->name('meals.members-list');
            Route::get('{user}/member-details', [KitchenController::class, 'memberDetails'])->name('meals.member-details');
            Route:: resource('meals',    KitchenController::class);
        });
        Route::get('/dashboard',[DashboardController::class ,'index'])->middleware(['auth', 'verified'])->name('dashboard');

    });
    Route::post('/dashboard',[DashboardController::class ,'changeTheme'])->middleware(['auth'])->name('change-theme');






    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
