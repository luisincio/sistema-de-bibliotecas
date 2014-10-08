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
							'nombre' => 'required|alpha_spaces|min:2|unique:profiles,name',
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
				// Edit the profiles in the database
				Input::merge(array_map('trim', Input::all()));
				$id = Input::get('id');
				$url = 'user/edit_profile/'.$id;
				$profile = Profile::find($id);
				$profile->description = Input::get('descripcion');
				$profile->save();
				Session::flash('message', 'Se editó correctamente el Perfil.');
				return Redirect::to($url);
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

}