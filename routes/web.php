<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::namespace('Bank')->middleware('auth')->group(function () {
    Route::get('deposit', 'BankingController@deposit')->name('deposit');
    Route::post('depositMoney', 'BankingController@depositMoney')->name('depositMoney');
    Route::get('withdraw', 'BankingController@withdraw')->name('withdraw');
    Route::post('withdrawMoney', 'BankingController@withdrawMoney')->name('withdrawMoney');
    Route::get('transfer', 'BankingController@transfer')->name('transfer');
    Route::post('transferMoney', 'BankingController@transferMoney')->name('transferMoney');
    Route::get('statement', 'BankingController@statement')->name('statement');
});
