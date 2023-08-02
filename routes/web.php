<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\LibraryController;
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



Route::group([ 'prefix'=>'sport','middleware' => 'auth'],function (){

    Route:: resource('sports',    GymController::class);

});
Route::group([ 'prefix'=>'meal','middleware' => 'auth'],function (){

    Route:: resource('meals',    KitchenController::class);

});


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

    Route:: resource('books',    LibraryController::class);
   // Route::put('/books/{id}/toggle-status', [RoomController::class, 'toggleStatus'])->name('rooms.toggle-status');


});







Route::get('/dashboard',[DashboardController::class ,'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/dashboard',[DashboardController::class ,'changeTheme'])->middleware(['auth'])->name('change-theme');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
