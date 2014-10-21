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
							'num_documento' => 'required|numeric|min:9999999|max:9999999999',
							'nombres' => 'required|alpha_spaces|min:2',
							'apellidos' => 'required|alpha_spaces|min:2',
							'nacionalidad' => 'required|alpha_spaces',
							'telefono' => 'required|numeric',
							'email' => 'required|email',
							'direccion' => 'required',
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
						$password = Str::random(16);
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
						$person_id = Person::orderBy('id','desc')->first();
					}else{
						$person_id = $person[0]->id;
					}
					$staff = new Staff;
					$staff->role_id = Input::get('rol');
					$staff->turn_id = Input::get('turno');
					$staff->person_id = $person_id;
					$staff->save();
					Session::flash('message', 'Se registró correctamente al personal.');
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
				$data["staffs_data"] = Staff::getStaffsInfo()->paginate(10);
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
				if($data["search_filter"] == 0){
					$data["staffs"] = Staff::searchStaffs($data["search_criteria"])->paginate(10);
				}elseif($data["search_filter"] == 1){
					$data["staffs"] = Staff::searchActiveStaffs($data["search_criteria"])->paginate(10);
				}else{
					$data["staffs"] = Staff::searchDeletedStaffs($data["search_criteria"])->paginate(10);
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

}