<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	$postcodes = DB::table('centrelink')->select(DB::raw('DISTINCT(postcode) as postcode'))->get();
	return View::make('pages.home')->with('postcodes', $postcodes);
});

Route::get('postcode', array('uses' => 'PostcodeController@index'));
Route::get('postcode/{postcode?}', array('uses' => 'PostcodeController@show'));


//General Pages
Route::get('/about', array('uses' => 'PagesController@about'));
Route::get('/contact', array('uses' => 'PagesController@contact'));
Route::get('/api', array('uses' => 'PagesController@api'));
