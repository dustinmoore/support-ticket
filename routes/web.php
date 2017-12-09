<?php

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

Route::get('/', 'TicketsController@userTickets');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Ticket Routes
Route::get('new_ticket', 'TicketsController@create');
Route::post('new_ticket', 'TicketsController@store');
Route::get('my_tickets', 'TicketsController@userTickets');
Route::get('tickets/{ticket_id}', 'TicketsController@show');

//Comment Routes
Route::post('comment', 'CommentsController@postComment');

//Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('tickets', 'TicketsController@index');
    Route::post('close_ticket/{ticket_id}', 'TicketsController@close');
    Route::get('create_user', 'Auth\ManageUsersController@create');
    Route::post('create_user', 'Auth\ManageUsersController@store');
    Route::get('manage_users', 'Auth\ManageUsersController@index');
    Route::get('user/{user_id}', 'Auth\ManageUsersController@show');
    Route::post('user/{user_id}', 'Auth\ManageUsersController@edit');
});