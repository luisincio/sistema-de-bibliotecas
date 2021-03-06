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
Route::controller('password', 'RemindersController');
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
	/* Devolution Period */
	Route::get('/create_devolution_period/','ConfigurationController@render_create_devolution_period');
	Route::post('/submit_create_devolution_period','ConfigurationController@submit_create_devolution_period'); 
	Route::post('/delete_devolution_period_ajax','ConfigurationController@delete_devolution_period_ajax'); 
	/* Penalty Period */
	Route::get('/create_penalty_period/','ConfigurationController@render_create_penalty_period');
	Route::post('/submit_create_penalty_period','ConfigurationController@submit_create_penalty_period'); 
	Route::post('/delete_penalty_period_ajax','ConfigurationController@delete_penalty_period_ajax'); 
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
	/* Physical Elements */
	Route::get('/list_physical_elements','ConfigurationController@list_physical_elements');
	Route::post('/get_physical_elements_by_branch','ConfigurationController@get_physical_elements_by_branch');
	Route::post('/submit_edit_physical_elements','ConfigurationController@submit_edit_physical_elements');
	Route::post('/submit_edit_shelves','ConfigurationController@submit_edit_shelves');
	Route::post('/submit_edit_cubicles','ConfigurationController@submit_edit_cubicles');
	Route::post('/submit_create_cubicles','ConfigurationController@submit_create_cubicles');
	Route::post('/submit_create_shelves','ConfigurationController@submit_create_shelves');
	Route::post('/submit_create_physical_elements','ConfigurationController@submit_create_physical_elements');
	Route::post('/delete_physical_elements','ConfigurationController@delete_physical_elements');
	Route::post('/delete_shelves','ConfigurationController@delete_shelves');
	Route::post('/delete_cubicle','ConfigurationController@delete_cubicle');
	/* Cubicle Types */
	Route::get('/create_cubicle_type','ConfigurationController@render_create_cubicle_type');
	Route::post('/submit_create_cubicle_type','ConfigurationController@submit_create_cubicle_type');
	Route::get('/list_cubicle_type','ConfigurationController@list_cubicle_type'); 
	Route::get('/edit_cubicle_type/{id}','ConfigurationController@render_edit_cubicle_type');
	Route::post('/submit_edit_cubicle_type','ConfigurationController@submit_edit_cubicle_type');
	Route::post('/delete_cubicle_type_ajax','ConfigurationController@delete_cubicle_type_ajax');
	/*Holidays*/
	Route::get('/create_holiday','ConfigurationController@render_create_holiday'); 
	Route::post('/delete_holiday_ajax','ConfigurationController@delete_holiday_ajax');
	Route::post('/register_holiday_ajax','ConfigurationController@register_holiday_ajax');
	/* Commands */
	Route::get('/render_commands','ConfigurationController@render_commands'); 
	Route::post('/clean_reservations_command','ConfigurationController@clean_reservations_command'); 
	Route::post('/clean_users_command','ConfigurationController@clean_users_command'); 
	Route::post('/penalize_users_command','ConfigurationController@penalize_users_command'); 
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

/* Staff */
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
	/* Assistance */
	Route::get('/assistance','StaffController@assistance');
	Route::post('/submit_assistance','StaffController@submit_assistance');
	Route::get('/staff_assistance/{id}','StaffController@staff_assistance');

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
	Route::get('/loan_register','LoanController@render_loan_register');
	Route::post('/validate_doc_number_loans_ajax','LoanController@validate_doc_number_loans_ajax');
	Route::post('/validate_material_code_ajax','LoanController@validate_material_code_ajax');
	Route::post('/register_loan_ajax','LoanController@register_loan_ajax');
	Route::post('/get_user_reservation_ajax','LoanController@get_user_reservation_ajax');
	Route::post('/register_loan_with_reservation_ajax','LoanController@register_loan_with_reservation_ajax');
	Route::get('/my_loans','LoanController@render_my_loans');
	Route::get('/force_expiration/{id}','LoanController@force_expiration');
	/* Register Material Damaged */
	Route::get('/damage_register','LoanController@render_damage_register');
	Route::get('/search_user_loans_damage','LoanController@search_user_loans_damage');
	Route::post('/damage_register_ajax','LoanController@damage_register_ajax');
	/* Renew */
	Route::post('/renew_ajax','LoanController@renew_ajax');
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
	Route::get('/force_expiration/{id}','ReservationController@force_expiration');
});

/* Reports */
Route::group(array('prefix'=>'report', 'before'=>'auth'),function(){
	/* Top Loans */
	Route::get('/top_loans','ReportController@render_top_loans');
	Route::post('/submit_top_loans','ReportController@submit_top_loans');
	Route::post('/submit_top_loans_excel','ReportController@submit_top_loans_excel');
	/* Most Requested Materials */
	Route::get('/most_requested_materials','ReportController@render_most_requested_materials');
	Route::post('/submit_most_requested_materials','ReportController@submit_most_requested_materials');
	Route::post('/submit_most_requested_materials_excel','ReportController@submit_most_requested_materials_excel');
	/* Restricted Users */
	Route::get('/restricted_users','ReportController@render_restricted_users');
	Route::post('/restricted_users_excel','ReportController@render_restricted_users_excel');
	/* Loans By User */
	Route::get('/loans_by_user','ReportController@render_loans_by_user');
	Route::post('/submit_loans_by_user','ReportController@submit_loans_by_user');
	Route::post('/submit_loans_by_user_excel','ReportController@submit_loans_by_user_excel');
	/* Last Material Entries */
	Route::get('/last_material_entries','ReportController@render_last_material_entries');
	Route::post('/submit_last_material_entries','ReportController@submit_last_material_entries');
	Route::post('/submit_last_material_entries_excel','ReportController@submit_last_material_entries_excel');
	/* Loans By Material */
	Route::get('/loans_by_material','ReportController@render_loans_by_material');
	Route::post('/submit_loans_by_material','ReportController@submit_loans_by_material');
	Route::post('/submit_loans_by_material_excel','ReportController@submit_loans_by_material_excel');
	/* Approver/Rejected Purchase Orders */
	Route::get('/approved_rejected_purchase_orders','ReportController@render_approved_rejected_purchase_orders');
	Route::post('/submit_approved_rejected_purchase_orders','ReportController@submit_approved_rejected_purchase_orders');
	Route::post('/submit_approved_rejected_purchase_orders_excel','ReportController@submit_approved_rejected_purchase_orders_excel');
	/* Loans By Teachers */
	Route::get('/loans_by_teachers','ReportController@render_loans_by_teachers');
	Route::post('/submit_loans_by_teachers','ReportController@submit_loans_by_teachers');
	Route::post('/submit_loans_by_teachers_excel','ReportController@submit_loans_by_teachers_excel');
});