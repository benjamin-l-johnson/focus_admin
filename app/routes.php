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

//Maybe the name should be index?
Route::any('/', array('uses' => 'LoginController@showLogin'));


//show the login page
Route::get('login', array('as'=> 'login','uses' => 'LoginController@showLogin'));

// route to process the form
Route::post('login', array('uses' => 'LoginController@doLogin'));


Route::get('logout', array('as'=>'logout','uses' => 'LoginController@doLogout'));

/* 
|-----------------------------------------------------------------------
|
| Make sure all users are authenticated before accessing the admin page	
|
|-----------------------------------------------------------------------
*/
Route::group(array('before'=>'auth'),function()
{
	Route::any('admin', array('as'=>'admin',function()
	{
		return View::make('admin.index');
	}));
	Route::resource('/admin/events','AdminEventController');

	Route::resource('/admin/members','AdminMemebersController');

	Route::resource('/admin/students','AdminStudentsController');

	Route::resource('/admin/nonprofits','AdminNonProfitController');

	Route::resource('/admin/volunteers','AdminVolunteersController');


	Route::post('/admin/members/order', array('as'=>'members.order','uses' => 'AdminMemebersController@saveOrder'));

});

Route::controller('password', 'RemindersController');
/*
|--------------------------------------------------------------------------
| Deploy Route
|--------------------------------------------------------------------------
|
| Look for the controller Server.php, if it exists. Then 
|
*/


if (file_exists(__DIR__.'/controllers/Server.php')) {
    Route::get('/deploy', 'Server@deploy');
}