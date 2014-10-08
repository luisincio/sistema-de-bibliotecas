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
							'nombre' => 'required|alpha|min:2|unique:profiles,name',
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
					$profile->name = Input::get('nombre');
					$profile->description = Input::get('descripcion');
					$profile->max_material = Input::get('max_materiales');
					$profile->max_days_loan = Input::get('max_dias_prestamo');
					$profile->save();

					$last_profile = Profile::orderBy('id', 'desc')->first();
					$id = $last_profile->id;

					$selected_material_types = Input::get('selected_material_types');
					foreach($selected_material_types as $selected_material_type){
						$material_typesxprofile = new MaterialTypexprofile;
						$material_typesxprofile->material_type_id = $selected_material_type;
						$material_typesxprofile->profile_id = $id;
						$material_typesxprofile->save();
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

}