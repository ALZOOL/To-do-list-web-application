<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterationController;
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

Route::view('/register', 'register')->name('register');;


//users Registeration
Route::controller(RegisterationController::class)->group(function(){
    Route::post('user/register','register_action')->name('user_register.process'); 
    
});
//##########