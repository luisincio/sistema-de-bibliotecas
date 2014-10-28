<?php

class StaffController extends BaseController {

	public function render_create_staff()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				$data["document_types"] = DocumentType::all();
				$data["roles"] = Role::all();
				$data["branches"] = Branch::all();
				$data["turns"] = Turn::all();
				$data["staff_turn"] = Turn::find($data["staff"]->turn_id);
				$data["staff_branch"] = Branch::find($data["staff_turn"]->branch_id);
				return View::make('staff/createStaff',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_staff()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				// Validate the info, create rules for the inputs
				$rules = array(
							'num_documento' => 'required|numeric|min:9999999|max:999999999999',
							'nombres' => 'required|alpha_spaces|min:2|max:255',
							'apellidos' => 'required|alpha_spaces|min:2|max:255',
							'nacionalidad' => 'required|alpha_spaces|max:128',
							'telefono' => 'required|numeric|min:999999|max:9999999999999',
							'email' => 'required|email|max:128',
							'direccion' => 'required|max:255',
							'fecha_nacimiento' => 'required',
							'genero' => 'required',
							'rol' => 'required|numeric|min:1',
							'turno' => 'required|numeric|min:1',
							'sede' => 'required|numeric|min:1',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('staff/create_staff')->withErrors($validator)->withInput(Input::all());
				}else{
					$document_number = Input::get('num_documento');
					$person = Person::searchPersonByDocument($document_number)->get();
					if($person->isEmpty()){
						// Create a random password
						$password = Str::random(8);
						//Create person
						$person = new Person;
						$person->doc_number = Input::get('num_documento');
						$person->password = Hash::make($password);
						$person->name = Input::get('nombres');
						$person->lastname = Input::get('apellidos');
						$person->birth_date = Input::get('fecha_nacimiento');
						$person->mail = Input::get('email');
						$person->address = Input::get('direccion');
						$person->gender = Input::get('genero');
						$person->phone = Input::get('telefono');
						$person->document_type = Input::get('tipo_doc');
						$person->nacionality = Input::get('nacionalidad');
						$person->save();

						Mail::send('emails.user_registration',array('person'=> $person,'password'=>$password),function($message) use ($person)
						{
							$message->to($person->mail, $person->name)
									->subject('Registro de nuevo Personal');
						});
						$person_id = Person::orderBy('id','desc')->first();
						$person_id = $person_id->id;
					}else{
						$person_id = $person[0]->id;
					}
					$staff_exist = Staff::searchStaffByPerson($person_id)->get();
					if($staff_exist->isEmpty()){
						$staff = new Staff;
						$staff->role_id = Input::get('rol');
						$staff->turn_id = Input::get('turno');
						$staff->person_id = $person_id;
						$staff->save();
						Session::flash('message', 'Se registró correctamente al personal.');
					}else{
						Session::flash('error', 'El personal ya existe.');
					}
					return Redirect::to('staff/create_staff');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_staff()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				// Check if the current user is the "System Admin"
				$data["search_criteria"] = null;
				if($data["staff"]->role_id == 1){
					$data["staffs_data"] = Staff::getStaffsInfo()->paginate(10);
				}elseif($data["staff"]->role_id == 2){
					$turn = Turn::find($data["staff"]->turn_id);
					$turns_by_branch = Turn::where('branch_id','=',$turn->branch_id)->get();
					$turns_array = [];
					foreach($turns_by_branch as $turn_by_branch){
						$turns_array[] = $turn_by_branch->id;
					}
					//$branch = Branch::find($turn->branch_id);
					$data["staffs_data"] = Staff::getStaffInfoByTurns($turns_array)->paginate(10);
				}
				$data["search"] = null;
				$data["search_filter"] = null;
				return View::make('staff/listStaff',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_staff()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();

			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				$data["search_criteria"] = Input::get('search');
				$data["search_filter"] = Input::get('search_filter');
				if($data["staff"]->role_id == 1){
					if($data["search_filter"] == 0){
						$data["staffs_data"] = Staff::searchStaffs($data["search_criteria"])->paginate(10);
					}elseif($data["search_filter"] == 1){
						$data["staffs_data"] = Staff::searchActiveStaffs($data["search_criteria"])->paginate(10);
					}else{
						$data["staffs_data"] = Staff::searchDeletedStaffs($data["search_criteria"])->paginate(10);
					}
				}else{
					$turn = Turn::find($data["staff"]->turn_id);
					$turns_by_branch = Turn::where('branch_id','=',$turn->branch_id)->get();
					$turns_array = [];
					foreach($turns_by_branch as $turn_by_branch){
						$turns_array[] = $turn_by_branch->id;
					}
					if($data["search_filter"] == 0){
						$data["staffs_data"] = Staff::searchStaffsByTurns($data["search_criteria"],$turns_array)->paginate(10);
					}elseif($data["search_filter"] == 1){
						$data["staffs_data"] = Staff::searchActiveStaffsByTurns($data["search_criteria"],$turns_array)->paginate(10);
					}else{
						$data["staffs_data"] = Staff::searchDeletedStaffsByTurns($data["search_criteria"],$turns_array)->paginate(10);
					}
				}
				$data["search"] = $data["search_criteria"];
				return View::make('staff/listStaff',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function delete_staff_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
		if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
			// Check if the current user is the "Bibliotecario"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$staff = Staff::find($selected_id);
				if($staff){
					$staff->delete();
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function reactivate_staff_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
		if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 ){
			// Check if the current user is the "Bibliotecario"
			$staff_id = Input::get('staff_id');
			$staff = Staff::withTrashed()->find($staff_id);
			$staff->restore();
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_edit_staff($id=null)
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if(($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 ) && $id){
				
				$data["document_types"] = DocumentType::all();
				$data["roles"] = Role::all();
				$data["branches"] = Branch::all();
				//$data["turns"] = Turn::all();
				$data["staff_info"] = Staff::searchStaffById($id)->get();
				if($data["staff_info"]->isEmpty()){
					return Redirect::to('staff/list_staff');
				}
				$data["staff_info"] = $data["staff_info"][0];
				$data["edit_staff_turn"] = Turn::find($data["staff_info"]->turn_id);
				$data["edit_staff_branch"] = Branch::find($data["edit_staff_turn"]->branch_id);
				$data["edit_staff_possible_turns"] = Turn::where('branch_id','=',$data["edit_staff_branch"]->id)->get();
				return View::make('staff/editStaff',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_staff()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombres' => 'required|alpha_spaces|min:2|max:255',
							'apellidos' => 'required|alpha_spaces|min:2|max:255',
							'nacionalidad' => 'required|alpha_spaces|max:128',
							'telefono' => 'required|numeric|min:999999|max:9999999999999',
							'email' => 'required|email|max:128',
							'direccion' => 'required|max:255',
							'fecha_nacimiento' => 'required',
							'genero' => 'required',
							'rol' => 'required|numeric|min:1',
							'turno' => 'required|numeric|min:1',
							'sede' => 'required|numeric|min:1',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$staff_id = Input::get('staff_id');
					$url = "staff/edit_staff"."/".$staff_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$person_id = Input::get('person_id');
					$person = Person::find($person_id);
					$person->name = Input::get('nombres');
					$person->lastname = Input::get('apellidos');
					$person->birth_date = Input::get('fecha_nacimiento');
					$person->mail = Input::get('email');
					$person->address = Input::get('direccion');
					$person->gender = Input::get('genero');
					$person->phone = Input::get('telefono');
					$person->nacionality = Input::get('nacionalidad');
					$person->save();

					$staff_id = Input::get('staff_id');
					$staff = Staff::find($staff_id);
					$staff->role_id = Input::get('rol');
					$staff->turn_id = Input::get('turno');
					$staff->save();

					Session::flash('message', 'Se editó correctamente al personal.');
					$url = "staff/edit_staff"."/".$staff_id;
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function get_turns_by_branch_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
		if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
			// Check if the current user is "Superadmin" or "Administrador de sede"
			$branch_id = Input::get('branch_id');
			$turns = Turn::where('branch_id','=',$branch_id)->get();
			return Response::json(array( 'success' => true ,'turns'=>$turns),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}	

	public function assistance()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 4){
				return View::make('staff/assistance',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_assistance()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 4){

				$num_doc = Input::get('num_doc');
				$password = Input::get('contrasena');
				$person = Person::searchPersonByDocument($num_doc)->first();
				if($person){
					if(Hash::check($password, $person->password)){
						$staff = Staff::where('person_id','=',$person->id)->first();
						if($staff){
							$today = Date("Y-m-d");

							$assistance = Assistance::getTodayStaffAssistance($staff->id,$today)->first();
							if($assistance){
								/* Check out */
								$hour = Date("H:i:s");
								$edit_assistance = Assistance::find($assistance->id);
								$edit_assistance->hour_out = $hour;
								$edit_assistance->save();
								Session::flash('message', 'Se registró correctamente la salida.');
								return Redirect::to('staff/assistance');
							}else{
								/* Check in */
								$hour = Date("H:i:s");
								$new_assistance = new Assistance;
								$new_assistance->staff_id = $staff->id;
								$new_assistance->hour_in = $hour;
								$new_assistance->date = $today;
								$new_assistance->save();
								Session::flash('message', 'Se registró correctamente la entrada.');
								return Redirect::to('staff/assistance');
							}
						}else{
							Session::flash('error', 'No se encontro al personal.');
							return Redirect::to('staff/assistance');
						}
					}else{
						Session::flash('error', 'Su contraseña es incorrecta.');
						return Redirect::to('staff/assistance');
					}
				}else{
					Session::flash('error', 'No se encontro al personal.');
					return Redirect::to('staff/assistance');
				}

			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
}