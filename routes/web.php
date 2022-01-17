<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

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

Route::group(["middleware" => "auth"], function () {
    Route::get('/', "HomeController@index", function () {
        return view('home');
    })->name("home");
    // Route::get('/', "DashboardController@index", function () {
    //     return view('dashboard');
    // });

    Route::group(['middleware' => 'can:view,folder'], function() {
        Route::get('/folders/{folder}/tasks', 'TaskController@index')->name('tasks.index');
        Route::get("/folders/{folder}/tasks/{task}/edit", "TaskController@showEditForm")->name("tasks.edit");
        Route::post("/folders/{folder}/tasks/{task}/edit", "TaskController@edit");
        Route::get("/folders/create", "FolderController@showCreateForm")->name("folders.create");
        Route::post("/folders/create", "FolderController@create");
    });
    Route::get("/folders/{folder}/tasks/create", "TaskController@showCreateForm")->name("tasks.create");
    Route::post("/folders/{folder}/tasks/create", "TaskController@create");
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
