<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function(){
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('companies',CompanyController::class);
        Route::post('company/update', [CompanyController::class, 'update'])->name('company.update');
        Route::get('company/{id}/delete/', [CompanyController::class, 'destroy'])->name('company.delete');
        Route::get('/get/companies',[CompanyController::class,'getCompany'])->name('getCompany');

        Route::resource('employees',EmployeeController::class);
        Route::post('employee/update', [EmployeeController::class, 'update'])->name('employee.update');
        Route::get('employee/{id}/delete/', [EmployeeController::class, 'destroy'])->name('employee.delete');
        Route::get('/get/employees',[EmployeeController::class,'getEmployee'])->name('getEmployee');
        Route::post('reset/credentials',[HomeController::class, 'resetCredentials'])->name('reset.credentials');
});