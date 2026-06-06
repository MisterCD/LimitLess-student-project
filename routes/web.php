<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainCOntroller;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
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

Route::get('/', [App\Http\Controllers\MainController::class, 'main_get'])->name('main');
Route::post('/login', [App\Http\Controllers\UserController::class, 'login_post'])->name('login');
Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout_post'])->name('logout');
Route::post('/changeUser', [App\Http\Controllers\UserController::class, 'changeUser_post'])->name('changeUser');
Route::post('/deleteUser', [App\Http\Controllers\UserController::class, 'deleteUser_post'])->name('deleteUser');
Route::post('/createMovie', [App\Http\Controllers\AdminController::class, 'createMovie_post'])->name('createMovie');
Route::post('/changeMovie', [App\Http\Controllers\AdminController::class, 'changeMovie_post'])->name('changeMovie');
Route::post('/deleteMovie', [App\Http\Controllers\AdminController::class, 'deleteMovie_post'])->name('deleteMovie');
Route::post('/allowRewiew', [App\Http\Controllers\AdminController::class, 'allowRewiew_post'])->name('allowRewiew');
Route::post('/deleteRewiew', [App\Http\Controllers\AdminController::class, 'deleteRewiew_post'])->name('deleteRewiew');
Route::post('/changeRewiew', [App\Http\Controllers\AdminController::class, 'changeRewiew_post'])->name('changeRewiew');
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'admin_users_get'])->name('admin_users');
Route::get('/admin/rewiews', [App\Http\Controllers\AdminController::class, 'admin_rewiews_get'])->name('admin_rewiews');
Route::get('/admin/rooms', [App\Http\Controllers\AdminController::class, 'admin_rooms_get'])->name('admin_rooms');
Route::post('/admin/addRoom', [App\Http\Controllers\AdminController::class, 'addRoom_post'])->name('addRoom');
Route::get('/admin/movies', [App\Http\Controllers\AdminController::class, 'admin_movies_get'])->name('admin_movies');
Route::post('/admin/deleteUser', [App\Http\Controllers\AdminController::class, 'deleteUser_post'])->name('deleteUser');
Route::post('/admin/changeUser', [App\Http\Controllers\AdminController::class, 'changeUser_post'])->name('changeUser');
Route::get('/admin/createMoviePage', [App\Http\Controllers\AdminController::class, 'createMoviePage_get'])->name('createMoviePage');
Route::post('/admin/createActor', [App\Http\Controllers\AdminController::class, 'createActor_post'])->name('createActor');
Route::get('/admin/createActorPage', [App\Http\Controllers\AdminController::class, 'createActorPage_get'])->name('createActorPage');
Route::post('/admin/allowRewiew', [App\Http\Controllers\AdminController::class, 'allowRewiew_post'])->name('allowRewiew');
Route::post('/admin/deleteRewiew', [App\Http\Controllers\AdminController::class, 'deleteRewiew_post'])->name('deleteRewiew');
Route::get('/login', [App\Http\Controllers\MainController::class, 'login_get'])->name('login');
Route::get('/movies', [App\Http\Controllers\MainController::class, 'movies_get'])->name('movies');
Route::get('/about', [App\Http\Controllers\MainController::class, 'about_get'])->name('about');
Route::get('/contacts', [App\Http\Controllers\MainController::class, 'contacts_get'])->name('contacts');
Route::get('/movie_page', [App\Http\Controllers\MainController::class, 'movie_page_get'])->name('movie_page');
Route::post('/createUser', [App\Http\Controllers\UserController::class, 'createUser_post'])->name('createUser');
Route::post('/createBooking', [App\Http\Controllers\UserController::class, 'createBooking_post'])->name('createBooking');
Route::post('/admin/cancleRewiew', [App\Http\Controllers\AdminController::class, 'cancleRewiew_post'])->name('cancleRewiew');
Route::post('/deleteRewiew', [App\Http\Controllers\UserController::class, 'deleteRewiew_post'])->name('deleteRewiew');
Route::post('/createRewiew', [App\Http\Controllers\UserController::class, 'createRewiew_post'])->name('createRewiew');
Route::get('/user', [App\Http\Controllers\UserController::class, 'user_get'])->name('user');
Route::post('/admin/deleteRoom', [App\Http\Controllers\AdminController::class, 'deleteRoom_post'])->name('deleteRoom');
Route::post('/admin/changeRoom', [App\Http\Controllers\AdminController::class, 'changeRoom_post'])->name('changeRoom');
Route::get('/admin/changeRoomPage', [App\Http\Controllers\AdminController::class, 'changeRoomPage_get'])->name('changeRoomPage');
Route::get('/admin/changeMoviePage', [App\Http\Controllers\AdminController::class, 'changeMoviePage_get'])->name('changeMoviePage');

Route::get('/registration', [App\Http\Controllers\UserController::class, 'register_get'])->name('register');
Route::get('/admin/addRoomPage', [App\Http\Controllers\AdminController::class, 'addRoomPage_get'])->name('addRoomPage');