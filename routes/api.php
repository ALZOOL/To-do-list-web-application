<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/token', function () {
//     return csrf_token(); 
// });


//users Registeration
Route::controller(RegisterationController::class)->group(function(){
    Route::post('user/register','register_action')->name('user_register.process'); 
    
});
//##########

//users login-logout
Route::controller(LoginController::class)->group(function(){
    Route::post('user/login','noter_login_action')->name('noter_login.process');
    Route::get('user/logout', 'noter_logout')->name('noter_logout');
});
//##########

//Notes Add-Edit-Delete
Route::controller(NotesController::class)->group(function(){
    Route::get('user/notes',"show_notes")->name('/notes');
    Route::post('user/add_notes',"add_notes");
    Route::post('user/note/delete',"delete_notes")->name('notes.delete');
    Route::PUT('user/note/update',"update_notes")->name('notes.update');

});
//##########

?>