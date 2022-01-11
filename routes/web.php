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

Route::get('/', "HomeController@index", function () {
    return view('home');
});
// Route::get('/', "DashboardController@index", function () {
//     return view('dashboard');
// });

Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');
Route::get("/folders/{id}/tasks/create", "TaskController@showCreateForm")->name("tasks.create");
Route::post("/folders/{id}/tasks/create", "TaskController@create");
Route::get("/folders/{id}/tasks/{task_id}/edit", "TaskController@showEditForm")->name("tasks.edit");
Route::post("/folders/{id}/tasks/{task_id}/edit", "TaskController@edit");
Route::get("/folders/create", "FolderController@showCreateForm")->name("folders.create");
Route::post("/folders/create", "FolderController@create");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
