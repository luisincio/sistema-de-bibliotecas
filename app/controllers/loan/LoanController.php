<?php

class LoanController extends BaseController
{
	public function render_return_register()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "Bibliotecario"
				Input::merge(array_map('trim', Input::all()));
				$data["search_criteria"] = Input::get('search');
				$data["search"] = $data["search_criteria"];
				$person = Person::searchPersonByDocument($data["search_criteria"])->first();
				$data["loans"] = null;
				$data["searched_user_name"] = null;
				if($person){
					$user = User::searchUserByPerson($person->id)->first();
					if($user){
						$data["searched_user_name"] = $person->name." ".$person->lastname;
						$data["loans"] = Loan::searchUserLoans($user->id)->paginate(10);
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
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
		$data["inside_url"] = Config::get('app.inside_url');
		$data["config"] = GeneralConfiguration::first();
		if($data["staff"]->role_id == 3){
			// Check if the current user is the "Bibliotecario"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$loan = Loan::find($selected_id);
				if($loan){
					$loan->delete();
					
					$material = Material::find($loan->material_id);
					if($material){
						$material->available = 1;
						$material->save();
					}
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}