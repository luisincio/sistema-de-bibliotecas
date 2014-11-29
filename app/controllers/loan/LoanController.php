<?php

class LoanController extends BaseController
{
	public function render_return_register()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "Bibliotecario"
				$data["loans"] = null;
				$data["search_criteria"] = null;
				$data["search"] = null;
				return View::make('loan/returnRegister',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
	public function search_user_loans()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "Bibliotecario"
				Input::merge(array_map('trim', Input::all()));
				$data["search_criteria"] = Input::get('search');
				$data["search"] = $data["search_criteria"];
				$person = Person::searchPersonByDocument($data["search_criteria"])->first();
				$data["loans"] = null;
				$data["user_id"] = null;
				$data["searched_user_name"] = null;
				if($person){
					$user = User::searchUserByPerson($person->id)->first();
					if($user){
						$data["searched_user_name"] = $person->name." ".$person->lastname;
						$data["loans"] = Loan::searchUserLoans($user->id)->paginate(10);
						$data["user_id"] = $user->id;
					}
				}
				return View::make('loan/returnRegister',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function return_register_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		$data["inside_url"] = Config::get('app.inside_url');
		$data["config"] = GeneralConfiguration::first();
		if($data["staff"]->role_id == 3){
			// Check if the current user is the "Bibliotecario"
			$selected_ids = Input::get('selected_id');
			$user_id = Input::get('user_id');
			$edit_user = User::find($user_id);
			foreach($selected_ids as $selected_id){
				$loan = Loan::find($selected_id);
				if($loan){
					$loan->delete();
					$edit_user->current_reservations = $edit_user->current_reservations - 1;
					$material = Material::find($loan->material_id);

					$next_reservation = MaterialReservation::getReservationByMaterial($material->mid)->first();

					if($next_reservation){
						/* Set the "available" flag on material to 2*/
						$material->available = 2;
						/* There's another reservation on the queue */
						$expire_at = date("Y-m-d", strtotime("tomorrow"));
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
			}
			$edit_user->save();
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

	public function render_loan_register()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "Bibliotecario"
				$turn = Turn::find($data["staff"]->turn_id);
				$data["branch"] = Branch::find($turn->branch_id);
				return View::make('loan/loanRegister',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	/* For Loans */
	public function validate_doc_number_loans_ajax()
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
			$document_number = Input::get('document_number');
			if(is_numeric($document_number) && $document_number > 9999999 && $document_number < 9999999999){
				$user = User::searchUserByDocument($document_number)->get();
				return Response::json(array( 'success' => true , 'user'=> $user),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function validate_material_code_ajax()
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
			$material_code = Input::get('material_code');
			if(ctype_alpha($material_code)){
				$material = Material::searchMaterialByCode($material_code)->get();
				return Response::json(array( 'success' => true , 'material'=> $material),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function register_loan_ajax()
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
			$user_id = Input::get('user_id');
			$base_cod_libro = Input::get('base_cod_libro');
			$branch_id = Input::get('branch_id');
			
			$material_available = Material::getAvailableMaterialByCodeBranch($base_cod_libro,$branch_id)->first();
			
			$user = User::find($user_id);
			$profile = Profile::find($user->profile_id);

			$first_time_material_loan = Loan::searchUserLoansByMaterial($user_id,$base_cod_libro)->first();

			$has_no_reservation = MaterialReservation::getReservationByUserMaterialCode($user_id,$base_cod_libro)->first();

			if(!$has_no_reservation){
				if(!$first_time_material_loan){
					if($user->current_reservations < $profile->max_material){
						if($material_available){
							$material = Material::find($material_available->mid);
							$material->available = 3;
							$material->save();

							$today = Date("Y-m-d");

							if($material->to_home == 1){

								$devolution_period = DevolutionPeriod::getDevolutionPeriodByDate($today)->first();

								if($devolution_period){
									$max_days_devolution = $devolution_period->max_days_devolution;
								}else{
									$max_days_devolution = $profile->max_days_loan;
								}
								$str_date = "+".$max_days_devolution." days";


								$devolution_date = date('Y-m-d', strtotime($str_date));

								$branch_labor_days = Material::getBranchLaborDaysByMaterial($material->mid)->first();
								$invalid_date = true;
								while($invalid_date){
									$is_holiday = Holiday::searchHoliday($devolution_date)->first();
									$devolution_date_timestamp = strtotime($devolution_date);
									$devolution_date_day = date('w', $devolution_date_timestamp);

									if( ($devolution_date_day >= $branch_labor_days->day_ini) && ($devolution_date_day <= $branch_labor_days->day_end)){
										$is_labor_day = true;
									}else{
										$is_labor_day = false;
									}
									
									if($is_holiday || !$is_labor_day){
										$devolution_date = date('Y-m-d', strtotime($devolution_date. ' + 1 days'));
									}else{
										$invalid_date = false;
									}
									
								}
							}else{
								$devolution_date = $today;
							}



							$loan = new Loan;
							$loan->expire_at = $devolution_date;
							$loan->material_id = $material->mid;
							$loan->user_id = $user_id;
							$loan->save();

							$user->current_reservations = $user->current_reservations + 1;
							$user->save();
							return Response::json(array( 'success' => true, 'problem' => false ),200);
						}else{
							return Response::json(array( 'success' => true, 'problem' => 'no_available' ),200);
						}
					}else{
						return Response::json(array( 'success' => true, 'problem' => 'max_reservations' ),200);
					}
				}else{
					return Response::json(array( 'success' => true, 'problem' => 'has_loans' ),200);
				}
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'has_reservations' ),200);
			}

		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function get_user_reservation_ajax()
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
			$document_number = Input::get('document_number');
			if(ctype_digit($document_number)){
				$user = User::searchUserByDocument($document_number)->first();
				if($user){
					$material_reservations = MaterialReservation::getUserReservationsForLoans($user->id)->get();
					return Response::json(array( 'success' => true, 'problem' => null ,'material_reservations'=> $material_reservations),200);
				}else{
					return Response::json(array( 'success' => true,'problem' => 'user_no_exist' ,'material_reservations'=> null ),200);
				}
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function register_loan_with_reservation_ajax()
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
			$reservation_id = Input::get('reservation_id');
			if(ctype_digit($reservation_id)){
				$material_reservation = MaterialReservation::find($reservation_id);
				if($material_reservation){
					$user = User::find($material_reservation->user_id);
					$profile = Profile::find($user->profile_id);

					$today = Date("Y-m-d");
					$devolution_period = DevolutionPeriod::getDevolutionPeriodByDate($today)->first();
					if($devolution_period){
						$max_days_devolution = $devolution_period->max_days_devolution;
					}else{
						$max_days_devolution = $profile->max_days_loan;
					}
					$str_date = "+".$max_days_devolution." days";
					$devolution_date = date('Y-m-d', strtotime($str_date));

					$loan = new Loan;
					$loan->expire_at = $devolution_date;
					$loan->material_id = $material_reservation->material_id;
					$loan->user_id = $material_reservation->user_id;
					$loan->save();

					$material_reservation->delete();

					return Response::json(array( 'success' => true ),200);
				}
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_my_loans()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["user"]){
				// Check if the current user is the "Bibliotecario"
				$data["today"] = Date("Y-m-d");
				$data["loans"] = Loan::searchUserLoans($data["user"]->id)->paginate(10);
				return View::make('loan/myLoans',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function render_damage_register()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "Bibliotecario"
				$data["loans"] = null;
				$data["search_criteria"] = null;
				$data["search"] = null;
				return View::make('loan/damageRegister',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_user_loans_damage()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "Bibliotecario"
				Input::merge(array_map('trim', Input::all()));
				$data["search_criteria"] = Input::get('search');
				$data["search"] = $data["search_criteria"];
				$person = Person::searchPersonByDocument($data["search_criteria"])->first();
				$data["loans"] = null;
				$data["user_id"] = null;
				$data["searched_user_name"] = null;
				if($person){
					$user = User::searchUserByPerson($person->id)->first();
					if($user){
						$data["searched_user_name"] = $person->name." ".$person->lastname;
						$data["loans"] = Loan::searchUserLoans($user->id)->paginate(10);
						$data["user_id"] = $user->id;
					}
				}
				return View::make('loan/damageRegister',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function damage_register_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		$data["inside_url"] = Config::get('app.inside_url');
		$data["config"] = GeneralConfiguration::first();
		if($data["staff"]->role_id == 3){
			// Check if the current user is the "Bibliotecario"
			$selected_ids = Input::get('selected_id');
			$user_id = Input::get('user_id');
			$edit_user = User::find($user_id);
			$days_penalty_count = 0; 

			$today = Date("Y-m-d");

			$penalty_period = PenaltyPeriod::getPenaltyPeriodByDate($today)->first();

			foreach($selected_ids as $selected_id){
				$loan = Loan::find($selected_id);
				if($loan){
					$loan->delete();
					$edit_user->current_reservations = $edit_user->current_reservations - 1;
					$material = Material::find($loan->material_id);
					/* Get all the reservations of the material to be deleted */
					$reservations = MaterialReservation::getReservationByMaterial($material->mid)->get();
					/* And delete them */
					foreach($reservations as $reservation){
						$delete_reservation = MaterialReservation::find($reservation->id);
						$delete_reservation->delete();
					}

					$material_type = MaterialType::find($material->material_type);
					if($penalty_period){
						$days_penalty_count = $penalty_period->penalty_days;
					}else{
						$days_penalty_count += $material_type->day_penalty;
					}

					$material->delete();
				}
			}
			if($edit_user->restricted_until){
				$today = $edit_user->restricted_until;
			}else{
				$today = Date("Y-m-d");
			}
			$restricted_until = date('Y-m-d', strtotime($today."+ ".$days_penalty_count." days"));
			$edit_user->restricted_until = $restricted_until;
			$edit_user->save();
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function renew_ajax()
	{
		$user_id = Input::get('user_id');
		$data["user"] = User::find($user_id);
		if($data["user"]){
			$loan_id = Input::get('loan_id');
			$material_id = Input::get('material_id');
			$is_reserved = MaterialReservation::where('material_id','=',$material_id)->first();
			if(!$is_reserved){
				
				$profile = Profile::find($data["user"]->profile_id);
				$material = Material::find($material_id);
				$today = Date("Y-m-d");
				
				if($material->to_home == 1){

					$devolution_period = DevolutionPeriod::getDevolutionPeriodByDate($today)->first();

					if($devolution_period){
						$max_days_devolution = $devolution_period->max_days_devolution;
					}else{
						$max_days_devolution = $profile->max_days_loan;
					}
					$str_date = "+".$max_days_devolution." days";


					$devolution_date = date('Y-m-d', strtotime($str_date));

					$branch_labor_days = Material::getBranchLaborDaysByMaterial($material->mid)->first();
					$invalid_date = true;
					while($invalid_date){
						$is_holiday = Holiday::searchHoliday($devolution_date)->first();
						$devolution_date_timestamp = strtotime($devolution_date);
						$devolution_date_day = date('w', $devolution_date_timestamp);

						if( ($devolution_date_day >= $branch_labor_days->day_ini) && ($devolution_date_day <= $branch_labor_days->day_end)){
							$is_labor_day = true;
						}else{
							$is_labor_day = false;
						}
						
						if($is_holiday || !$is_labor_day){
							$devolution_date = date('Y-m-d', strtotime($devolution_date. ' + 1 days'));
						}else{
							$invalid_date = false;
						}
						
					}

					$loan = Loan::find($loan_id);
					$loan->expire_at = $devolution_date;
					$loan->save();
					return Response::json(array( 'success' => true),200);
				}
				return Response::json(array( 'success' => true, 'error' => 'not_home' ),200);
			}else{
				return Response::json(array( 'success' => true, 'error' => 'is_reserved' ),200);
			}

		}else{
			return Response::json(array( 'success' => false ),200);
		}
		
	}

	public function force_expiration($id=null)
	{
		if(Auth::check()){
			$uid = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($uid)->user;
			$data["staff"] = Person::find($uid)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if( $id && $data["user"]){
				// Check if the current user is the "System Admin"

				$loan = Loan::find($id);
				if($loan){
					$yesterday = Date('Y-m-d',strtotime("-1 days"));
					$loan->expire_at = $yesterday;
					$loan->save();
					return Redirect::to('loan/my_loans');
				}else{
					return View::make('error/error');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

}