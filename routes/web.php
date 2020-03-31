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

use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('home');
});
Route::get('/gdpr', function () {
    return view('gdpr');
});
Route::get('/new-page', 'PageController@newPage');
Route::get('/delete-page', 'PageController@deletePage');
Route::post('/deleted', 'PageController@deleted');
Route::get('/edit-page', 'PageController@editPage');
Route::post('/update-page', 'PageController@updatePage');
Route::post('/save-page', 'PageController@savePage');
Route::get('/page/{uuid}', 'PageController@showPage');
