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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/Home', function(){
//     return view('Home.index');
// });
Route::get('/Home','HomeController@index')->name('Home.index');
Route::get('/Department','HomeController@department')->name('Home.department');

//Login Page Route
Route::get('/Login','LoginController@index')->name('Login.index');
Route::post('/Login','LoginController@verifyUser')->name('Login.verifyUser');

//Admin Page Route
Route::get('/admin','AdminController@index')->name('Admin.index');

//HR Page Route
Route::get('/HR', 'HRController@index')->name('HR.index');
Route::get('/HR/Chart', 'HRController@chart')->name('HR.chart');
Route::get('/HR/AddDoctor', 'HRController@addDoctor')->name('HR.addDoctor');
