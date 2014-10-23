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
Route::get('/catalog', 'HomeController@render_catalog');
Route::get('/submit_catalog', 'HomeController@submit_catalog');
Route::post('/material_detail_ajax', 'HomeController@material_detail_ajax');
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
	/* Branches */
	Route::get('/create_branch','ConfigurationController@render_create_branch');
	Route::post('/submit_create_branch','ConfigurationController@submit_create_branch');
	Route::get('/list_branch','ConfigurationController@list_branch'); 
	Route::get('/edit_branch/{id}','ConfigurationController@render_edit_branch');
	Route::post('/submit_edit_branch','ConfigurationController@submit_edit_branch');
	Route::post('/restore_branch_ajax','ConfigurationController@restore_branch_ajax');
	Route::post('/delete_branch_ajax','ConfigurationController@delete_branch_ajax');
	/* Turns */
	Route::get('/create_turn/{id}','ConfigurationController@render_create_turn');
	Route::post('/submit_create_turn','ConfigurationController@submit_create_turn'); 
	Route::post('/search_turn','ConfigurationController@search_turn');
	Route::post('/delete_turn_ajax','ConfigurationController@delete_turn_ajax');

});

/* My Account */
Route::group(array('prefix'=>'myaccount', 'before'=>'auth'),function(){
	Route::get('/change_password','MyAccountController@render_change_password');
	Route::post('/submit_change_password','MyAccountController@submit_change_password');
	Route::get('/create_material_request','MyAccountController@render_create_material_request');
	Route::post('/submit_create_material_request','MyAccountController@submit_create_material_request');
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

/* staff */
Route::group(array('prefix'=>'staff', 'before'=>'auth'),function(){
	Route::get('/create_staff','StaffController@render_create_staff');
	Route::post('/submit_create_staff','StaffController@submit_create_staff');
	Route::get('/list_staff','StaffController@list_staff');

	Route::get('/search_staff','StaffController@search_staff');
	Route::post('/delete_staff_ajax','StaffController@delete_staff_ajax');
	Route::post('/reactivate_staff_ajax','StaffController@reactivate_staff_ajax');
	Route::get('/edit_staff/{id}','StaffController@render_edit_staff');
	Route::post('/submit_edit_staff','StaffController@submit_edit_staff');
	Route::post('/get_turns_by_branch_ajax','StaffController@get_turns_by_branch_ajax');

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
	Route::get('/list_material_request','MaterialController@list_material_request');
	Route::get('/search_material_request','MaterialController@search_material_request');
	/* Purchase Orders */
	Route::get('/create_purchase_order','MaterialController@render_create_purchase_order');
	Route::post('/submit_create_purchase_order','MaterialController@submit_create_purchase_order');
	Route::get('/list_purchase_order','MaterialController@list_purchase_order');
	Route::get('/search_purchase_order','MaterialController@search_purchase_order');
	Route::get('/edit_purchase_order/{id}','MaterialController@render_edit_purchase_order');
	Route::post('/submit_edit_purchase_order','MaterialController@submit_edit_purchase_order');
	Route::post('/submit_reject_purchase_order_ajax','MaterialController@submit_reject_purchase_order_ajax');
});

/* Loans */
Route::group(array('prefix'=>'loan', 'before'=>'auth'),function(){
	Route::get('/return_register','LoanController@render_return_register');
	Route::get('/search_user_loans','LoanController@search_user_loans');
	Route::post('/return_register_ajax','LoanController@return_register_ajax');
});

/* Catalog */
Route::group(array('prefix'=>'catalog', 'before'=>'auth'),function(){
	Route::get('/catalog','CatalogController@render_catalog');
	Route::get('/submit_catalog', 'CatalogController@submit_catalog');
});

/* Reservation */
Route::group(array('prefix'=>'reservation', 'before'=>'auth'),function(){
	Route::post('/material_reservation_ajax','ReservationController@material_reservation_ajax');
	Route::get('/my_material_reservations','ReservationController@my_material_reservations');
	Route::post('/delete_material_reservations_ajax','ReservationController@delete_material_reservations_ajax');
	Route::get('/cubicle_reservations','ReservationController@render_cubicle_reservations');
	Route::post('/search_cubicle_ajax','ReservationController@search_cubicle_ajax');
	Route::post('/cubicle_reservation_detail_ajax','ReservationController@cubicle_reservation_detail_ajax');
	Route::post('/cubicle_submit_reservation_ajax','ReservationController@cubicle_submit_reservation_ajax');
	Route::get('/search_cubicle_reservations','ReservationController@render_search_cubicle_reservations');
	Route::post('/submit_search_cubicle_reservations','ReservationController@submit_search_cubicle_reservations');
	Route::get('/my_cubicle_reservations','ReservationController@render_my_cubicle_reservations');
	Route::post('/delete_cubicle_reservations_ajax','ReservationController@delete_cubicle_reservations_ajax');
});