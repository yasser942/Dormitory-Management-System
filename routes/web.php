<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
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



Route::group([ 'prefix'=>'room','middleware' => 'auth'],function (){

    Route:: resource('rooms',    RoomController::class);
    Route::put('/rooms/{id}/toggle-status', [RoomController::class, 'toggleStatus'])->name('rooms.toggle-status');


});

Route::group([ 'prefix'=>'student','middleware' => 'auth'],function (){

    Route:: resource('students',    StudentController::class);
    Route::put('/students/{id}/toggle-status', [StudentController::class, 'toggleStatus'])->name('students.toggle-status');


});
Route::group([ 'prefix'=>'employee','middleware' => 'auth'],function (){

    Route:: resource('employees',    EmployeeController::class);
    Route::put('/employees/{id}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');


});
Route::group([ 'prefix'=>'book','middleware' => 'auth'],function (){

    Route:: resource('books',    LibraryController::class);
   // Route::put('/books/{id}/toggle-status', [RoomController::class, 'toggleStatus'])->name('rooms.toggle-status');


});







Route::get('/dashboard',[DashboardController::class ,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
