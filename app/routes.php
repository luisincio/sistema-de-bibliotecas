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