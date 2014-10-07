<?php

class MyAccountController extends BaseController
{
	public function render_change_password()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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

}