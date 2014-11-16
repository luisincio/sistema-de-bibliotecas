<?php

class MyAccountController extends BaseController
{
	public function render_change_password()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			return View::make('myaccount/changePassword',$data);
		}else{
			return View::make('error/error');
		}
	}

	public function submit_change_password()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Validate the info, create rules for the inputs
			$rules = array(
						'contrasena' => 'required|alphaNum|min:6|max:16|confirmed'
					);
			// Run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);
			// If the validator fails, redirect back to the form
			if($validator->fails()){
				return Redirect::to('myaccount/change_password')->withErrors($validator);
			}else{
				$person = Person::find($data["person"]->id);
				$person->password = Hash::make(Input::get('contrasena'));
				$person->save();

				Session::flash('message', 'Se modificó correctamente la contraseña.');
				return Redirect::to('myaccount/change_password');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_material_request()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["user"]->profile_id == 1 || $data["user"]->profile_id == 2){
				// Check if the current user is student or proffesor"
				$data["material_request_types"] = MaterialRequestType::all();				
				return View::make('myaccount/createMaterialRequest',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_material_request()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["user"]->profile_id == 1 || $data["user"]->profile_id == 2){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'titulo' => 'required|min:2|max:255',	
							'autor' => 'required|alpha_spaces|min:2|max:255',
							'editorial' => 'required|alpha_spaces|max:128',
							'num_edicion' => 'required|numeric|min:1|max:10000',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('myaccount/create_material_request')->withErrors($validator)->withInput(Input::all());
				}else{
					$fecha = date_create();
					$material = new MaterialRequest;
					$material->date = $fecha;
					$material->title = Input::get('titulo');
					$material->author = Input::get('autor');
					$material->editorial = Input::get('editorial');
					$user = Session::get('user');
					$material->user_id = $user->id;
					$material->edition = Input::get('num_edicion');
					$material->material_request_type_id = Input::get('tipo_sugerencia');
					$material->save();
					Session::flash('message', 'Se registró correctamente la solicitud.');
					return Redirect::to('myaccount/create_material_request');
				}

			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

}