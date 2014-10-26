<?php

class UserController extends BaseController {

	public function render_create_profile()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				// Check if the current user is the "System Admin"
				$data["material_types"] = MaterialType::all();
				return View::make('user/createProfile',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function submit_create_profile()
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
							'nombre' => 'required|alpha_spaces|min:2|max:255|unique:profiles,name',
							'max_materiales' => 'required|numeric|min:1|max:50',
							'max_dias_prestamo' => 'required|numeric|min:1|max:365',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('user/create_profile')->withErrors($validator)->withInput(Input::all());
				}else{
					// Insert the profile in the database
					$profile = new Profile;
					$profile->name = trim(Input::get('nombre'));
					$profile->description = trim(Input::get('descripcion'));
					$profile->max_material = Input::get('max_materiales');
					$profile->max_days_loan = Input::get('max_dias_prestamo');
					$profile->save();

					$last_profile = Profile::orderBy('id', 'desc')->first();
					$id = $last_profile->id;

					$selected_material_types = Input::get('selected_material_types');
					if($selected_material_types){
						foreach($selected_material_types as $selected_material_type){
							$material_typesxprofile = new MaterialTypexprofile;
							$material_typesxprofile->material_type_id = $selected_material_type;
							$material_typesxprofile->profile_id = $id;
							$material_typesxprofile->save();
						}
					}
					Session::flash('message', 'Se registró correctamente el perfil.');
					return Redirect::to('user/create_profile');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function list_profile()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				// Check if the current user is the "System Admin"
				$data["profiles"] = Profile::paginate(10);
				return View::make('user/listProfile',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_profile($id=null)
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if(($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2) && $id){
				// Check if the current user is the "System Admin"
				$data["material_types"] = MaterialType::all();
				$data["profile"] = Profile::find($id);
				$aux_array = MaterialTypexprofile::getMaterialTypesXProfile($id)->select('material_type_id')->get()->toArray();
				if(!empty($aux_array)){
					$data["material_typesxprofile_before"] = $aux_array;
					$data["material_typesxprofile"] =[];
					foreach($data["material_typesxprofile_before"] as $item){
						$data["material_typesxprofile"][]=$item['material_type_id'];
					}
				}else{
					$data["material_typesxprofile"] = [];
				}
				return View::make('user/editProfile',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_profile()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				
				$rules = array(
							
							'max_materiales' => 'required|numeric|min:1|max:50',
							'max_dias_prestamo' => 'required|numeric|min:1|max:365',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$profile_id = Input::get('id');
					$url = "user/edit_profile"."/".$profile_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{

					$id = Input::get('id');
					$url = 'user/edit_profile/'.$id;
					$profile = Profile::find($id);
					$profile->description = Input::get('descripcion');
					$profile->max_material = Input::get('max_materiales');
					$profile->max_days_loan = Input::get('max_dias_prestamo');
					$profile->save();

					$data["material_types"] = MaterialType::all();
					foreach($data["material_types"] as $item){
						$empty = MaterialTypexprofile::getRowByProfileIdMaterialTypeId($id,$item->id)->get();
						if(!$empty->isEmpty()){
							$material_typeXprofile = MaterialTypexprofile::find($empty[0]->id);
							$material_typeXprofile->delete();
						}
					}

					$selected_material_types = Input::get('selected_material_types');
					if($selected_material_types){
						foreach($selected_material_types as $selected_material_type){
							$material_typesxprofile = new MaterialTypexprofile;
							$material_typesxprofile->material_type_id = $selected_material_type;
							$material_typesxprofile->profile_id = $id;
							$material_typesxprofile->save();
						}
					}
					Session::flash('message', 'Se editó correctamente el Perfil.');
					return Redirect::to($url);
				}	
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function delete_profile_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
		$data["inside_url"] = Config::get('app.inside_url');
		$data["config"] = GeneralConfiguration::first();
		if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$profile = Profile::find($selected_id);
				$profile->delete();
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_create_user()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				
				$data["document_types"] = DocumentType::all();
				$data["profiles"] = Profile::all();
				return View::make('user/createUser',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function validate_doc_number_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
		if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
			$document_number = Input::get('document_number');
			if(is_numeric($document_number) && $document_number > 9999999 && $document_number < 9999999999){
				$person = Person::searchPersonByDocument($document_number)->get();
				return Response::json(array( 'success' => true , 'person'=> $person),200);
			}else{
				return Response::json(array( 'success' => false ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_create_user()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
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
							'perfil' => 'required|numeric|min:1',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('user/create_user')->withErrors($validator)->withInput(Input::all());
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
									->subject('Registro de nuevo usuario');
						});

						$person_id = Person::orderBy('id','desc')->first();
						$person_id = $person_id->id;
					}else{
						$person_id = $person[0]->id;
					}

					$user_exist = User::searchUserByPerson($person_id)->get();
					if($user_exist->isEmpty()){
						$user = new User;
						$user->profile_id = Input::get('perfil');
						$user->person_id = $person_id;
						$user->save();
						Session::flash('message', 'Se registró correctamente al usuario.');
					}else{
						Session::flash('error', 'El usuario ya existe.');
					}
					return Redirect::to('user/create_user');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_user()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				// Check if the current user is the "System Admin"
				$data["search_criteria"] = null;
				$data["users_data"] = User::getUsersInfo()->paginate(10);

				$data["search"] = null;
				$data["search_filter"] = null;
				return View::make('user/listUser',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_user()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();

			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				
				$data["search_criteria"] = Input::get('search');
				$data["search_filter"] = Input::get('search_filter');

				if($data["search_filter"] == 0){
					$data["users_data"] = User::searchUsers($data["search_criteria"])->paginate(10);
				}elseif($data["search_filter"] == 1){
					$data["users_data"] = User::searchActiveUsers($data["search_criteria"])->paginate(10);
				}else{
					$data["users_data"] = User::searchDeletedUsers($data["search_criteria"])->paginate(10);
				}
				$data["search"] = $data["search_criteria"];
				return View::make('user/listUser',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function delete_user_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
		if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
			// Check if the current user is the "Bibliotecario"
			$selected_ids = Input::get('selected_id');
			$users_with_loans = [];
			foreach($selected_ids as $selected_id){
				$loan = Loan::where('user_id','=',$selected_id)->first();
				if($loan){
					$user_info = User::searchUserById($selected_id)->first();
					$users_with_loans[] = $user_info->name;
				}else{
					/* Delete the user */
					$user = User::find($selected_id);
					if($user){
						$user->delete();
					}
					/* Cancel all reservations */
					CubicleReservation::where('user_id','=',$selected_id)->delete();
					MaterialReservation::where('user_id','=',$selected_id)->delete();
				}
			}
			return Response::json(array( 'success' => true,'users_with_loans' => $users_with_loans ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function reactivate_user_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
		if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
			// Check if the current user is the "Bibliotecario"
			$user_id = Input::get('user_id');
			$user = User::withTrashed()->find($user_id);
			$user->restore();
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_edit_user($id=null)
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if(($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3) && $id){
				
				$data["document_types"] = DocumentType::all();
				$data["profiles"] = Profile::all();
				$data["user_info"] = User::searchUserById($id)->get();
				if($data["user_info"]->isEmpty()){
					return Redirect::to('user/list_user');
				}
				$data["user_info"] = $data["user_info"][0];
				return View::make('user/editUser',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_user()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				
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
							'perfil' => 'required|numeric|min:1',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$user_id = Input::get('user_id');
					$url = "user/edit_user"."/".$user_id;
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
					$person->document_type = Input::get('tipo_doc');
					$person->nacionality = Input::get('nacionalidad');
					$person->save();

					$user_id = Input::get('user_id');
					$user = User::find($user_id);
					$user->profile_id = Input::get('perfil');
					$user->save();

					Session::flash('message', 'Se editó correctamente al usuario.');
					$url = "user/edit_user"."/".$user_id;
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

}