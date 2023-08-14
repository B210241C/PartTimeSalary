<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\UsersController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('userDashboard', function () {return view('userDashboard');})->name('userDashboard');
Route::resource('attendances', AttendancesController::class);




Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('dashboard', function () {return view('dashboard');})->name('dashboard');
    Route::post('changeToUser/{id}',[UsersController::class,'changeToUser'])->name('changeToUser');
    Route::get('checkoutlist',[UsersController::class,'checkoutlist'])->name('checkoutlist');
    Route::post('checkout/{id}',[UsersController::class,'checkout'])->name('checkout');
    Route::get('pendingApprove',[AttendancesController::class,'pendingApprove'])->name('pendingApprove');
    Route::post('attendances/{id}',[AttendancesController::class,'verifyAttendance'])->name('verifyAttendance');
    Route::get('adminIndex',[UsersController::class,'adminIndex'])->name('adminIndex');
    Route::resource('users', UsersController::class);
    Route::resource('branches', BranchesController::class);
    Route::get('pendingApprove',[AttendancesController::class,'pendingApprove'])->name('pendingApprove');
    Route::post('attendances/{id}',[AttendancesController::class,'verifyAttendance'])->name('verifyAttendance');
    Route::get('adminIndex',[UsersController::class,'adminIndex'])->name('adminIndex');
});


