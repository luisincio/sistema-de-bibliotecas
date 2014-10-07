<?php

class LoginController extends BaseController
{
	public function login()
	{
		// Implemento la reglas para la validacion de los datos
		$rules = array(
					'doc_number' => 'required|alphaNum|min:6',
					'password' => 'required|alphaNum|min:6'
				);
		// Corro la validacion
		$validator = Validator::make(Input::all(), $rules);
		// Si falla la validacion se redirige al login con un mensaje de error
		if($validator->fails()){
			Session::flash('error', 'Ingrese los campos correctamente');
			return Redirect::to('/')->withInput(Input::except('password'));
		}else{
			// Se crea un arreglo de datos para intentar la autenticacion
			$userdata = array(
							'doc_number' => Input::get('doc_number'),
							'password' => Input::get('password')
						);
			// Se intenta autenticar al usuario
			if(Auth::attempt($userdata)){
				// Si la autenticacion es exitosa guardo en la variable de sesión la información del usuario
				$id = Auth::id();
				$person = Auth::user();
				$user = Person::find($id)->user;
				$staff = Person::find($id)->staff;
				Session::put('person',$person);
				Session::put('user',$user);
				Session::put('staff',$staff);
				return Redirect::to('/dashboard');
			}else{
				// Si falla la autenticacion se lo regresa al login con un mensaje de error
				Session::flash('error', 'Usuario y/o contraseña incorrectos');
				return Redirect::to('/')->withInput(Input::except('password'));
			}
		}
	}

	public function logout()
	{
		// Cierro la sesion del usuario
		Auth::logout();
		Session::flush();
		return Redirect::to('/');
	}	
}