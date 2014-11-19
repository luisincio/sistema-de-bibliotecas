<?php

class ReservationController extends BaseController
{
	public function material_reservation_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ,'problem'=>'not_ajax' ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if( !$data["user"]->restricted_until ){
			$user_profile = Profile::find($data["user"]->profile_id);
			if($data["user"]->current_reservations >= $user_profile->max_material){
				return Response::json(array( 'success' => false ,'problem'=>'max_materials'),200);
			}else{

				$material_code = Input::get('material_code');
				$material_branch = Input::get('material_branch');
				$material_shelf = Input::get('material_shelf');

				$material = Material::getMaterialForReservation($material_code,$material_shelf)->first();

				// Check if the current user can reserve the material by its material type permission
				$material_types_available = MaterialTypexprofile::getMaterialTypesXProfile($data["user"]->profile_id)->get();
				$material_types_available_array = [];
				if(count($material_types_available)>0){
					foreach($material_types_available as $material_type_available){
						$material_types_available_array[] = $material_type_available->material_type_id;
					}
				}
				if( in_array($material->material_type,$material_types_available_array) ){
					$has_reservation = MaterialReservation::getReservationByUserMaterialCode($data["user"]->id,$material->base_cod)->first();
					if(!$has_reservation){
						$has_loan = Loan::searchUserLoansByMaterial($data["user"]->id,$material->base_cod)->first();
						if(!$has_loan){
							$reservation_date = date("Y-m-d");
							
							$material_reservation = new MaterialReservation;
							$material_reservation->reservation_date = $reservation_date;
							$material_reservation->user_id = $data["user"]->id;
							$material_reservation->material_id = $material->mid;
							if($material->available == 1){
								$update_material = Material::find($material->mid);
								$update_material->available = 2;
								$update_material->save();

								$expire_at = date("Y-m-d", strtotime("tomorrow"));

								$branch_labor_days = Material::getBranchLaborDaysByMaterial($material->mid)->first();
								
								$invalid_date = true;
								
								while($invalid_date){
									$is_holiday = Holiday::searchHoliday($expire_at)->first();
									$expire_at_timestamp = strtotime($expire_at);
									$expire_at_day = date('w', $expire_at_timestamp);

									if( ($expire_at_day >= $branch_labor_days->day_ini) && ($expire_at_day <= $branch_labor_days->day_end)){
										$is_labor_day = true;
									}else{
										$is_labor_day = false;
									}
									
									if($is_holiday || !$is_labor_day){
										$expire_at = date('Y-m-d', strtotime($expire_at. ' + 1 days'));
									}else{
										$invalid_date = false;
									}
									
								}
								

								$material_reservation->expire_at = $expire_at;
							}
							$material_reservation->save();

							/* Refresh the current_reservations number of the user */
							$update_user = User::find($data["user"]->id);
							$update_user->current_reservations = $update_user->current_reservations + 1;
							$update_user->save();
							/* Refresh the user info stored in Session */
							$id = Auth::id();
							$data["user"] = Person::find($id)->user;
							Session::forget('user');
							Session::put('user',$data["user"]);
							return Response::json(array( 'success' => true ,'material_available'=>$material->available),200);
						}else{
							return Response::json(array( 'success' => false ,'problem'=>'has_loan'),200);
						}
					}else{
						return Response::json(array( 'success' => false ,'problem'=>'has_reservation'),200);
					}
				}else{
					return Response::json(array( 'success' => false ,'problem'=>'material_type_unavailable'),200);
				}
			}

		}else{
			return Response::json(array( 'success' => false,'problem'=>'restricted_user' ),200);
		}
	}

	public function my_material_reservations()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["user"]){
				// Check if the current person has an user account
				$data["reservations"] = MaterialReservation::getUserReservations($data["user"]->id)->paginate(10);
				return View::make('reservation/listReservations',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function delete_material_reservations_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["user"]){
			// Check if the current user is the "Bibliotecario"
			$selected_ids = Input::get('selected_id');
			$update_user = User::find($data["user"]->id);

			foreach($selected_ids as $selected_id){
				$material_reservation = MaterialReservation::find($selected_id);
				if($material_reservation){
					$material_reservation->delete();
					$update_user->current_reservations = $update_user->current_reservations - 1;
				}
				$next_reservation = MaterialReservation::getReservationByMaterial($material_reservation->material_id)->first();
				$material = Material::find($material_reservation->material_id);
				if($next_reservation){
					/* Set the "available" flag on material to 2*/
					$material->available = 2;
					/* There's another reservation on the queue */
					$expire_at = date("Y-m-d", strtotime("tomorrow"));

					$branch_labor_days = Material::getBranchLaborDaysByMaterial($material->mid)->first();
					
					$invalid_date = true;
					
					while($invalid_date){
						$is_holiday = Holiday::searchHoliday($expire_at)->first();
						$expire_at_timestamp = strtotime($expire_at);
						$expire_at_day = date('w', $expire_at_timestamp);

						if( ($expire_at_day >= $branch_labor_days->day_ini) && ($expire_at_day <= $branch_labor_days->day_end)){
							$is_labor_day = true;
						}else{
							$is_labor_day = false;
						}
						
						if($is_holiday || !$is_labor_day){
							$expire_at = date('Y-m-d', strtotime($expire_at. ' + 1 days'));
						}else{
							$invalid_date = false;
						}
						
					}

					$next_reservation = MaterialReservation::find($next_reservation->id);
					$next_reservation->expire_at = $expire_at;
					$next_reservation->save();

					$next_user = User::find($next_reservation->user_id);
					$next_person = Person::find($next_user->person_id);
					Mail::send('emails.available_material', array('title'=>$material->title), function($message) use ($next_person)
					{
						$message->to($next_person->email, $next_person->name)
								->subject('Libro disponible para préstamo');
					});
				}else{
					$material->available = 1;
				}
				$material->save();
			}

			$update_user->save();
			/* Refresh the user info stored in Session */
			$id = Auth::id();
			$data["user"] = Person::find($id)->user;
			Session::forget('user');
			Session::put('user',$data["user"]);
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_cubicle_reservations()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["user"]){
				// Check if the current person has an user account
				$data["cubicles"] = null;
				$data["branches"] = Branch::all();
				$data["cubicle_types"] = CubicleType::all();
				return View::make('reservation/listCubicles',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_cubicle_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		$data["config"] = GeneralConfiguration::first();
		if($data["user"]){
			$branch_id = Input::get('branch_id');
			$cubicle_type_id = Input::get('cubicle_type_id');
			$data["branch"] = Branch::find($branch_id);
			$data["cubicles"] = Cubicle::getCubicleByBranchType($branch_id,$cubicle_type_id)->get();
			if($data["cubicles"]->isEmpty()){
				$data["cubicle_reservations"] = [];
			}else{
				$today = Date("Y-m-d");
				$cubicles_array = [];
				foreach($data["cubicles"] as $single_cubicle){
					$cubicles_array[] = $single_cubicle->id;
				}
				$data["cubicle_reservations"] = CubicleReservation::getReservationsByCubiclesDate($cubicles_array,$today)->get();
			}
			return Response::json(array( 'success' => true,'branch'=>$data["branch"],'cubicles'=>$data["cubicles"],'cubicle_reservations'=>$data["cubicle_reservations"],'max_cubicle_loan'=>$data["config"]->max_hours_loan_cubicle),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function cubicle_reservation_detail_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["user"]){
			$reservation_id = Input::get('reservation_id');
			$reservation = CubicleReservation::find($reservation_id);
			if($reservation){
				$user = User::find($reservation->user_id);
				if($user){
					$person = Person::find($user->person_id);
					if($person){
						return Response::json(array( 'success' => true,'cubicle_reservation'=>$reservation,'person'=>$person),200);
					}
				}
			}

			return Response::json(array( 'success' => false ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function cubicle_submit_reservation_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["user"]){
			/* Validate if the user has no reservation */
			$today = Date("Y-m-d");
			$has_reservation = CubicleReservation::getReservationByUserDate($data["user"]->id,$today)->first();
			
			if(!$has_reservation){
				/* If the user has no reservation */
				$cubicle_id = Input::get('cubicle_id_form');
				$cubicle_reservation_form_num_person = Input::get('cubicle_reservation_form_num_person');
				$cubicle_reservation_form_hour_in = Input::get('cubicle_reservation_form_hour_in');
				$cubicle_reservation_form_hour_out = Input::get('cubicle_reservation_form_hour_out');

				$cubicle_reservation = new CubicleReservation;
				$cubicle_reservation->hour_in = $cubicle_reservation_form_hour_in;
				$cubicle_reservation->hour_out = $cubicle_reservation_form_hour_out;
				$cubicle_reservation->num_person = $cubicle_reservation_form_num_person;
				$cubicle_reservation->cubicle_id = $cubicle_id;
				$cubicle_reservation->user_id = $data["user"]->id;
				$cubicle_reservation->reserved_at = $today;
				$cubicle_reservation->save();
				return Response::json(array( 'success' => true, 'reservation_done' => true ),200);
			}
			
			return Response::json(array( 'success' => true , 'reservation_done' => false ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_search_cubicle_reservations()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current staff is a "Bibliotecario"
				$data["search"] = null;
				return View::make('reservation/searchCubicleReservations',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_search_cubicle_reservations()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current staff is a "Bibliotecario"
				// Validate the info, create rules for the inputs
				$rules = array(
							'search' => 'required|numeric',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reservation/search_cubicle_reservations')->withErrors($validator)->withInput(Input::all());
				}
				$today = Date("Y-m-d");
				$data["search"] = Input::get('search');
				$data["reservation_person"] = Person::searchPersonByDocument($data["search"])->first();
				if($data["reservation_person"]){
					$reservation_user = User::searchUserByPersonId($data["reservation_person"]->id)->first();
					if($reservation_user){
						$data["reservations"] = CubicleReservation::getReservationCubicleByUserDate($reservation_user->id,$today)->get();
					}else{
						$data["reservations"] = null;
					}
				}else{
					$reservation_user = null;
					$data["reservations"] = null;
				}
				return View::make('reservation/searchCubicleReservations',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_my_cubicle_reservations()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["user"]){
				// Check if the current staff is a "Bibliotecario"
				$today = Date("Y-m-d");
				$data["reservations"] = CubicleReservation::getReservationCubicleByUserDate($data["user"]->id,$today)->get();
				return View::make('reservation/myCubicleReservations',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function delete_cubicle_reservations_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 3){
			// Check if the current user is the "Bibliotecario"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$cubicle_reservations = CubicleReservation::find($selected_id);
				if($cubicle_reservations){
					$cubicle_reservations->delete();
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

}