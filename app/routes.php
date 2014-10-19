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

Route::get('/', 'HomeController@home');
/* Login */
Route::post('/login', 'LoginController@login');
/* Dashboard */
Route::group(array('before'=>'auth'),function(){
	Route::get('/logout','LoginController@logout');
	Route::get('/dashboard','DashboardController@home');
});

/* Configuration */
Route::group(array('prefix'=>'config', 'before'=>'auth'),function(){
	/* General Information */
	Route::get('/general_configuration','ConfigurationController@render_general_configuration');
	Route::post('/submit_general_configuration','ConfigurationController@submit_general_configuration');
	/* Suppliers */
	Route::get('/create_supplier','ConfigurationController@render_create_supplier');
	Route::post('/submit_create_supplier','ConfigurationController@submit_create_supplier');
	Route::get('/list_supplier','ConfigurationController@list_supplier');
	Route::get('/search_supplier','ConfigurationController@search_supplier');
	Route::post('/delete_supplier_ajax','ConfigurationController@delete_supplier_ajax');
	Route::get('/edit_supplier/{id}','ConfigurationController@render_edit_supplier');
	Route::post('/submit_edit_supplier','ConfigurationController@submit_edit_supplier');
	/* Material Types */
	Route::get('/create_material_type','ConfigurationController@render_create_material_type');
	Route::post('/submit_create_material_type','ConfigurationController@submit_create_material_type');
	Route::get('/list_material_type','ConfigurationController@list_material_type');
	Route::post('/delete_material_type_ajax','ConfigurationController@delete_material_type_ajax');
	Route::get('/edit_material_type/{id}','ConfigurationController@render_edit_material_type');
	Route::post('/submit_edit_material_type','ConfigurationController@submit_edit_material_type');

});

/* My Account */
Route::group(array('prefix'=>'myaccount', 'before'=>'auth'),function(){
	Route::get('/change_password','MyAccountController@render_change_password');
	Route::post('/submit_change_password','MyAccountController@submit_change_password');
});


/* Users */
Route::group(array('prefix'=>'user', 'before'=>'auth'),function(){
	/* Profiles */
	Route::get('/create_profile','UserController@render_create_profile');
	Route::post('/submit_create_profile','UserController@submit_create_profile');
	Route::get('/list_profile','UserController@list_profile');
	Route::get('/edit_profile/{id}','UserController@render_edit_profile');
	Route::post('/submit_edit_profile','UserController@submit_edit_profile');
	Route::post('/delete_profile_ajax','UserController@delete_profile_ajax');
	/* Users */
	Route::get('/create_user','UserController@render_create_user');
	Route::post('/validate_doc_number_ajax','UserController@validate_doc_number_ajax');
	Route::post('/submit_create_user','UserController@submit_create_user');
	Route::get('/list_user','UserController@list_user');
	Route::get('/search_user','UserController@search_user');
	Route::post('/delete_user_ajax','UserController@delete_user_ajax');
	Route::post('/reactivate_user_ajax','UserController@reactivate_user_ajax');
	Route::get('/edit_user/{id}','UserController@render_edit_user');
	Route::post('/submit_edit_user','UserController@submit_edit_user');
});

/* Materials */
Route::group(array('prefix'=>'material', 'before'=>'auth'),function(){
	Route::get('/create_material','MaterialController@render_create_material');
	Route::post('/submit_create_material','MaterialController@submit_create_material');
	Route::get('/list_material','MaterialController@list_material');
	Route::get('/search_material','MaterialController@search_material');
	Route::post('/delete_material_ajax','MaterialController@delete_material_ajax');
	Route::get('/edit_material/{id}','MaterialController@render_edit_material');
	Route::post('/submit_edit_material','MaterialController@submit_edit_material');
});

/* Loans */
Route::group(array('prefix'=>'loan', 'before'=>'auth'),function(){
	Route::get('/return_register','LoanController@render_return_register');
	Route::get('/search_user_loans','LoanController@search_user_loans');
	Route::post('/return_register_ajax','LoanController@return_register_ajax');
});