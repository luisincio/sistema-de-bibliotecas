<?php

class ConfigurationController extends BaseController
{
	/**/

	public function render_create_cubicle_type()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				return View::make('configuration/createCubicleType',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_cubicle_type()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:45|unique:cubicle_types,name,NULL,id,deleted_at,NULL',
							'descripcion' => 'alpha_spaces|min:2|max:255',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('config/create_cubicle_type')->withErrors($validator)->withInput(Input::all());
				}else{
					// Insert the cubicle type in the database
					$cubicle_type = new CubicleType;
					$cubicle_type->name = Input::get('nombre');
					$cubicle_type->description = Input::get('descripcion');
					$cubicle_type->save();

					Session::flash('message', 'Se registró correctamente el tipo de cubículo.');
					return Redirect::to('config/create_cubicle_type');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_cubicle_type()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["cubicle_types"] = CubicleType::paginate(10);
				return View::make('configuration/listCubicleType',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_cubicle_type($id=null)
	{
		if(Auth::check()){
			$uid = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($uid)->user;
			$data["staff"] = Person::find($uid)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 && $id){
				// Check if the current user is the "System Admin"
				$data["cubicle_type"] = CubicleType::find($id);
				return View::make('configuration/editCubicleType',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_cubicle_type()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'descripcion' => 'alpha_spaces|min:2|max:255'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$url = 'config/edit_cubicle_type/'.Input::get('id');
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					// Insert the supplier in the database
					$id = Input::get('id');
					$url = 'config/edit_cubicle_type/'.$id;
					$cubicle_type = CubicleType::find($id);
					$cubicle_type->description = Input::get('descripcion');
					$cubicle_type->save();

					Session::flash('message', 'Se editó correctamente el tipo de cubículo.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function delete_cubicle_type_ajax()
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
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$cubicle_type = CubicleType::find($selected_id);
				if($cubicle_type){
					$cubicle = Cubicle::where('cubicle_type_id','=',$cubicle_type->id)->first();
					if(!$cubicle){
						$cubicle_type->delete();
					}
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	/**/
	public function render_create_supplier()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				return View::make('configuration/createSupplier',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_supplier()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:45|unique:suppliers,name',
							'representante' => 'required|alpha_spaces|min:2|max:255',
							'direccion' => 'required',
							'telefono' => 'numeric',
							'celular' => 'numeric',
							'email' => 'required|email',
							'ruc' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('config/create_supplier')->withErrors($validator)->withInput(Input::all());
				}else{
					$ruc = Input::get('ruc');

					if(ctype_digit($ruc) && ((strlen($ruc) == 11)||(strlen($ruc) == 8))){
						// Insert the supplier in the database
						$supplier = new Supplier;
						$supplier->name = Input::get('nombre');
						$supplier->ruc = Input::get('ruc');
						$supplier->sales_representative = Input::get('representante');
						$supplier->address = Input::get('direccion');
						$supplier->phone = Input::get('telefono');
						$supplier->cell = Input::get('celular');
						$supplier->email = Input::get('email');
						$supplier->flag_doner = Input::get('donador');
						$supplier->save();

						Session::flash('message', 'Se registró correctamente al proveedor.');
					}else{
						Session::flash('danger', 'El ruc/dni debe ser numérico de 8 u 11 dígitos');
						return Redirect::to('config/create_supplier')->withInput(Input::all());
					}
					return Redirect::to('config/create_supplier');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_supplier()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["search_criteria"] = null;
				$data["suppliers"] = Supplier::paginate(10);
				$data["search"] = null;
				return View::make('configuration/listSupplier',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_supplier()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["search_criteria"] = Input::get('search');
				$data["search_filter"] = Input::get('search_filter');
				if($data["search_filter"] == 1){
					$data["suppliers"] = Supplier::searchSuppliers($data["search_criteria"])->paginate(10);
				}elseif($data["search_filter"] == 2){
					$data["suppliers"] = Supplier::searchDoners($data["search_criteria"])->paginate(10);
				}else{
					$data["suppliers"] = Supplier::searchSuppliersDoners($data["search_criteria"])->paginate(10);
				}
				$data["search"] = $data["search_criteria"];
				return View::make('configuration/listSupplier',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function delete_supplier_ajax()
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
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$supplier = Supplier::find($selected_id);
				if($supplier){
					$supplier->delete();
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_edit_supplier($id=null)
	{
		if(Auth::check()){
			$uid = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($uid)->user;
			$data["staff"] = Person::find($uid)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 && $id){
				// Check if the current user is the "System Admin"
				$data["supplier"] = Supplier::find($id);
				return View::make('configuration/editSupplier',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_supplier()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'representante' => 'required|alpha_spaces|min:2|max:255',
							'direccion' => 'required',
							'telefono' => 'integer',
							'celular' => 'integer',
							'email' => 'required|max:128|email',
							'ruc' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$url = 'config/edit_supplier/'.Input::get('id');
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					// Insert the supplier in the database
					$id = Input::get('id');
					$url = 'config/edit_supplier/'.$id;
					$supplier = Supplier::find($id);
					$supplier->sales_representative = Input::get('representante');
					$supplier->address = Input::get('direccion');
					$supplier->phone = Input::get('telefono');
					$supplier->cell = Input::get('celular');
					$supplier->email = Input::get('email');
					$supplier->save();

					Session::flash('message', 'Se editó correctamente al proveedor.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_general_configuration()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["general_configuration"] = GeneralConfiguration::first();
				return View::make('configuration/generalConfiguration',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_general_configuration()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:45',
							'direccion' => 'required|max:255',
							'logo' => 'image',
							'tiempo_maximo_prestamo_cubiculo' => 'required|integer|min:1|max:24',
							'descripcion' => 'alpha_spaces|max:255',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('config/general_configuration')->withErrors($validator);
				}else{

					$ruc = Input::get('ruc');
					if(ctype_digit($ruc) && (strlen($ruc) == 11)){
						$logo = Input::file('logo');
						// Save the edition
						$config = GeneralConfiguration::first();
						$config->name = Input::get('nombre');
						$config->ruc = Input::get('ruc');
						$config->address = Input::get('direccion');
						if($logo){
							$config->logo_path = $logo->getClientOriginalName();
							$logo->move('img',$logo->getClientOriginalName());
						}
						$config->description = Input::get('descripcion');
						$config->max_hours_loan_cubicle = Input::get('tiempo_maximo_prestamo_cubiculo');
						$config->save();

						Session::flash('message', 'Se modificó correctamente la configuración general.');
					}else{
						Session::flash('danger', 'El ruc debe ser numérico de 11 dígitos');
					}
					return Redirect::to('config/general_configuration');
				}

				$data["general_configuration"] = GeneralConfiguration::first();
				return View::make('configuration/generalConfiguration',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function render_create_material_type()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				return View::make('configuration/createMaterialType',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function submit_create_material_type()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:45|unique:material_types,name',
							'descripcion' => 'required|max:255',
							'penalidad' => 'required|numeric|min:1|max:365'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('config/create_material_type')->withErrors($validator)->withInput(Input::all());
				}else{
					// Insert the supplier in the database
					$material_type = new MaterialType;
					$material_type->name = Input::get('nombre');
					$material_type->description = Input::get('descripcion');
					$material_type->day_penalty = Input::get('penalidad');
					$material_type->flag_phys_dig = Input::get('phys_dig');
					$material_type->save();

					Session::flash('message', 'Se registró correctamente el nuevo tipo de material.');
					return Redirect::to('config/create_material_type');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_material_type()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["material_types"] = MaterialType::paginate(10);
				return View::make('configuration/listMaterialType',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function delete_material_type_ajax()
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
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$material_type = MaterialType::find($selected_id);
				if($material_type){
					$material_type->delete();
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_edit_material_type($id=null)
	{
		if(Auth::check()){
			$uid = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($uid)->user;
			$data["staff"] = Person::find($uid)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 && $id){
				// Check if the current user is the "System Admin"
				$data["material_type"] = MaterialType::find($id);
				return View::make('configuration/editMaterialType',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_material_type()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){

				//Validation
				$rules = array(
					'descripcion' => 'max:255',
					'penalidad' => 'numeric|min:1|max:365'
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);

				// Edit the material_type in the database
				Input::merge(array_map('trim', Input::all()));
				$id = Input::get('id');
				$url = 'config/edit_material_type/'.$id;
				$material_type = MaterialType::find($id);
				$material_type->description = Input::get('descripcion');
				$material_type->day_penalty = Input::get('penalidad');
				$material_type->flag_phys_dig = Input::get('phys_dig');
				$material_type->save();

				Session::flash('message', 'Se editó correctamente el tipo de material.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_create_branch()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				return View::make('configuration/createBranch',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function submit_create_branch()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:128|unique:material_types,name|unique:branches,name',
							'direccion' => 'required|max:255'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('config/create_branch')->withErrors($validator)->withInput(Input::all());
				}else{
					$array_hora_ini = explode(":", Input::get('hora_ini'));
					$array_hora_fin = explode(":", Input::get('hora_fin'));
					if($array_hora_ini[0]*100 + $array_hora_ini[1] < $array_hora_fin[0]*100 + $array_hora_fin[1]){
						// Insert the supplier in the database
						$branch = new Branch;
						$branch->name = Input::get('nombre');
						$branch->address = Input::get('direccion');
						$branch->hour_ini = Input::get('hora_ini');
						$branch->hour_end = Input::get('hora_fin');
						$branch->day_ini = Input::get('dia_ini');
						$branch->day_end = Input::get('dia_fin');
						$branch->save();

						$branch_id = Branch::orderBy('id','desc')->first();
						$turn = new Turn;
						$turn->name = 'General';
						$turn->hour_ini = Input::get('hora_ini');
						$turn->hour_end = Input::get('hora_fin');
						$turn->branch_id = $branch_id->id;
						$turn->save();

						Session::flash('message', 'Se registró correctamente la nueva sede.');
						return Redirect::to('config/create_branch');
					}
					else{
						Session::flash('danger', 'La hora fin debe ser mayor a la hora de inicio.');
						return Redirect::to('config/create_branch')->withInput(Input::all());						
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_branch()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				if($data["staff"]->role_id == 1){
					// Check if the current user is the "System Admin"
					$data["branches"] = Branch::withTrashed()->get();
				}else{
					$turn = Turn::find($data["staff"]->turn_id);
					$branch = Branch::find($turn->branch_id);
					$data["branches"] = [];
					$data["branches"][] = $branch;
				}
				return View::make('configuration/listBranch',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_branch($id=null)
	{
		if(Auth::check()){
			$uid = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($uid)->user;
			$data["staff"] = Person::find($uid)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 && $id){
				// Check if the current user is the "System Admin"
				$data["branch"] = Branch::withTrashed()->find($id);
				return View::make('configuration/editBranch',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_branch()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){

				//Validation
				$rules = array(
					'direccion' => 'max:255',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				if($validator->fails())
				{					
					$id = Input::get('id');
					$url = 'config/edit_branch/'.$id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}

				$array_hora_ini = explode(":", Input::get('hora_ini'));
				$array_hora_fin = explode(":", Input::get('hora_fin'));
				if($array_hora_ini[0]*100 + $array_hora_ini[1] < $array_hora_fin[0]*100 + $array_hora_fin[1]){
					// Edit the branch in the database
					Input::merge(array_map('trim', Input::all()));
					$id = Input::get('id');
					$url = 'config/edit_branch/'.$id;
					$branch = Branch::find($id);
					$branch->address = Input::get('direccion');
					$branch->hour_ini = Input::get('hora_ini');
					$branch->hour_end = Input::get('hora_fin');
					$branch->save();

					Session::flash('message', 'Se editó correctamente la sede.');
					return Redirect::to($url);
				}
				else{
					$id = Input::get('id');
					$url = 'config/edit_branch/'.$id;
					Session::flash('danger', 'La hora fin debe ser mayor a la hora de inicio.');
					return Redirect::to($url)->withInput(Input::all());						
				}	
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function restore_branch_ajax()
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
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$branch_id = Input::get('branch_id');
			$branch = Branch::withTrashed()->find($branch_id);
			if($branch){
				$branch->restore();
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}	

	public function delete_branch_ajax()
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
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$branch = Branch::find($selected_id);

				if($branch){
					/* Check if the branch has at least one staff related */
					$turns = Turn::where('branch_id','=',$branch->id)->get();
					$turns_array = array();
					foreach($turns as $turn){
						$turns_array[] = $turn->id;
					}
					if(count($turns_array) > 0){
						$exist_staff = Staff::whereIn('turn_id',$turns_array)->first();
					}else{
						$exist_staff = null;
					}

					/* Check if the branch has at least one material related */
					
					$shelves = Shelf::where('branch_id','=',$branch->id)->get();
					$shelves_array = array();
					foreach($shelves as $shelf){
						$shelves_array[] = $shelf->id;
					}
					if(count($shelves_array) > 0){
						$exist_material = Material::whereIn('shelve_id',$shelves_array)->first();
					}else{
						$exist_material = null;
					}
					
					/* If the branch is related with nothing, then it can be deleted */
					if(!$exist_staff && !$exist_material){
						$branch->delete();
					}
					
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_create_turn($branch_id=null)
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				// Check if the current user is the "System Admin"
				if($branch_id){
					$data["turns"] = Turn::getTurnsByBranch($branch_id)->get();
					$data["branch_id"] = $branch_id;
					return View::make('configuration/createTurn',$data);
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

	public function submit_create_turn()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:128',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$branch_id = Input::get('branch_id');
					$url = 'config/create_turn/'.$branch_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$array_hora_ini = explode(":", Input::get('hora_ini'));
					$array_hora_fin = explode(":", Input::get('hora_fin'));
					$branch_id = Input::get('branch_id');
					if($array_hora_ini[0]*100 + $array_hora_ini[1] < $array_hora_fin[0]*100 + $array_hora_fin[1]){
						// Insert the turn in the database
						$turn_name = Input::get('nombre');
						$turn_exists = Turn::getTurnsByNameBranch($turn_name,$branch_id)->first();
						if(!$turn_exists){
							$turn = new Turn;
							$turn->name = $turn_name;
							$turn->hour_ini = Input::get('hora_ini');
							$turn->hour_end = Input::get('hora_fin');
							$turn->branch_id = $branch_id;
							$turn->save();

							$last_turn = Turn::orderBy('id', 'desc')->first();
							$id = $last_turn->id;

							Session::flash('message', 'Se registró correctamente el turno.');
							$url = 'config/create_turn/'.$branch_id;
							return Redirect::to($url);
						}else{
							Session::flash('danger', 'Ya existe un turno con ese nombre.');
							$url = 'config/create_turn/'.$branch_id;
							return Redirect::to($url)->withInput(Input::all());
						}
					}
					else{
						Session::flash('danger', 'La hora fin debe ser mayor a la hora de inicio.');
						$url = 'config/create_turn/'.$branch_id;
						return Redirect::to($url)->withInput(Input::all());
					}	
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function delete_turn_ajax()
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
		if($data["staff"]->role_id == 1 || $data["staff"]->role_id == 2){
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$turn = Turn::find($selected_id);
				if($turn){
					$exist_staff = Staff::where('turn_id','=',$turn->id)->first();
					if(!$exist_staff){
						$turn->delete();
					}
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
	/* Penalty Periods */
	public function render_create_penalty_period()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["penalty_periods"] = PenaltyPeriod::all();
				return View::make('configuration/createPenaltyPeriod',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}	
	}

	public function submit_create_penalty_period()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|unique:penalty_periods,name,NULL,id,deleted_at,NULL',
							'dias_penalidad' => 'required|numeric|integer|min:1|max:99',
							'fecha_ini' => 'required',
							'fecha_fin' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('config/create_penalty_period')->withErrors($validator)->withInput(Input::all());
				}else{
					if(strtotime(Input::get('fecha_ini')) < strtotime(Input::get('fecha_fin'))){
						// Insert the penalty period in the database
						$penalty_period = new PenaltyPeriod;
						$penalty_period->name = Input::get('nombre');
						$penalty_period->date_ini = Input::get('fecha_ini');
						$penalty_period->date_end = Input::get('fecha_fin');
						$penalty_period->penalty_days = Input::get('dias_penalidad');
						$penalty_period->save();

						Session::flash('message', 'Se registró correctamente el periodo de penalidad.');
						return Redirect::to('config/create_penalty_period');
					}
					else{
						Session::flash('danger', 'La fecha fin debe ser posterior a la fecha de inicio.');
						return Redirect::to('config/create_penalty_period')->withInput(Input::all());						
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function delete_penalty_period_ajax()
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
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$penalty_period = PenaltyPeriod::find($selected_id);
				if($penalty_period){
					$penalty_period->delete();
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
	/* Devolution Periods */
	public function render_create_devolution_period()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["devolution_periods"] = DevolutionPeriod::all();
				return View::make('configuration/createDevolutionPeriod',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}	
	}

	public function submit_create_devolution_period()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|max:45|unique:devolution_periods,name,NULL,id,deleted_at,NULL',
							'description' => 'min:2|max:128',
							'max_dias_devolucion' => 'required|numeric|integer|min:1|max:99',
							'fecha_ini' => 'required',
							'fecha_fin' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('config/create_devolution_period')->withErrors($validator)->withInput(Input::all());
				}else{
					if(strtotime(Input::get('fecha_ini')) < strtotime(Input::get('fecha_fin'))){
						// Insert the devolution period in the database
						$devolution_period = new DevolutionPeriod;
						$devolution_period->name = Input::get('nombre');
						$devolution_period->date_ini = Input::get('fecha_ini');
						$devolution_period->date_end = Input::get('fecha_fin');
						$devolution_period->max_days_devolution = Input::get('max_dias_devolucion');
						$devolution_period->description = Input::get('descripcion');
						$devolution_period->save();

						Session::flash('message', 'Se registró correctamente el periodo de devolución.');
						return Redirect::to('config/create_devolution_period');
					}
					else{
						Session::flash('danger', 'La fecha fin debe ser posterior a la fecha de inicio.');
						return Redirect::to('config/create_devolution_period')->withInput(Input::all());						
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function delete_devolution_period_ajax()
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
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$devolution_period = DevolutionPeriod::find($selected_id);
				if($devolution_period){
					$devolution_period->delete();
				}
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	/* Physical Elements */
	public function list_physical_elements()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				$data["branches"] = Branch::all();
				$data["cubicle_types"] = CubicleType::all();
				return View::make('configuration/listPhysicalElements',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function get_physical_elements_by_branch()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$branch_id = Input::get('branch_id');
			$branch_cubicles = Cubicle::getCubicleByBranch($branch_id)->get();
			$cubicle_types = CubicleType::all();
			$branch_physical_elements = PhysicalElement::getPhysicalElementsByBranch($branch_id)->get();
			$branch_shelves = Shelf::getShelvesByBranch($branch_id)->get();
			return Response::json(array( 'success' => true, 'branch_cubicles'=>$branch_cubicles, 'cubicle_types'=>$cubicle_types, 'branch_physical_elements'=>$branch_physical_elements, 'branch_shelves'=>$branch_shelves ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_edit_physical_elements()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$id = Input::get('id');
			$name = Input::get('name');
			$branch_id = Input::get('branch_id');
			$validate_name = PhysicalElement::getPhysicalElementByNameDifferentId($id,$name,$branch_id)->first();
			if(!$validate_name){
				$quantity = Input::get('quantity');
				$physical_element = PhysicalElement::find($id);
				$physical_element->name = $name;
				$physical_element->quantity = $quantity;
				$physical_element->save();
				return Response::json(array( 'success' => true, 'problem' => false ),200);
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'name_exists' ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_edit_shelves()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$id = Input::get('id');
			$code = Input::get('code');
			$validate_code = Shelf::getShelfByCodeDifferentId($id,$code)->first();
			if(!$validate_code){
				$description = Input::get('description');
				$shelf = Shelf::find($id);
				$shelf->code = $code;
				$shelf->description = $description;
				$shelf->save();
				return Response::json(array( 'success' => true, 'problem' => false ),200);
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'code_exists' ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_edit_cubicles()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$id = Input::get('id');
			$code = Input::get('code');
			$validate_code = Cubicle::getCubicleByCodeDifferentId($id,$code)->first();

			if(!$validate_code){
				$capacity = Input::get('capacity');
				$cubicle_type = Input::get('cubicle_type');
				$cubicle = Cubicle::find($id);
				$cubicle->code = $code;
				$cubicle->capacity = $capacity;
				$cubicle->cubicle_type_id = $cubicle_type;
				$cubicle->save();
				return Response::json(array( 'success' => true, 'problem' => false ),200);
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'code_exists' ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_create_cubicles()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$code = Input::get('code');
			$validate_code = Cubicle::getCubicleByCode($code)->first();

			if(!$validate_code){
				$capacity = Input::get('capacity');
				$cubicle_type = Input::get('cubicle_type');
				$branch_id = Input::get('branch_id');
				$cubicle = new Cubicle;
				$cubicle->code = $code;
				$cubicle->capacity = $capacity;
				$cubicle->cubicle_type_id = $cubicle_type;
				$cubicle->branch_id = $branch_id;
				$cubicle->save();
				return Response::json(array( 'success' => true, 'problem' => false ),200);
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'code_exists' ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_create_shelves()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$code = Input::get('code');
			$validate_code = Shelf::getShelfByCode($code)->first();

			if(!$validate_code){
				$description = Input::get('description');
				$branch_id = Input::get('branch_id');
				$shelf = new Shelf;
				$shelf->code = $code;
				$shelf->description = $description;
				$shelf->branch_id = $branch_id;
				$shelf->save();
				return Response::json(array( 'success' => true, 'problem' => false ),200);
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'code_exists' ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_create_physical_elements()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$name = Input::get('name');
			$branch_id = Input::get('branch_id');
			$validate_name = PhysicalElement::getPhysicalElementByName($name,$branch_id)->first();

			if(!$validate_name){
				$quantity = Input::get('quantity');
				$physical_element = new PhysicalElement;
				$physical_element->name = $name;
				$physical_element->quantity = $quantity;
				$physical_element->branch_id = $branch_id;
				$physical_element->save();
				return Response::json(array( 'success' => true, 'problem' => false ),200);
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'name_exists' ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function delete_physical_elements()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$id = Input::get('id');
			$physical_element = PhysicalElement::find($id);
			$physical_element->delete();
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function delete_shelves()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$id = Input::get('id');
			$exist_material = Material::where('shelve_id','=',$id)->first();
			if(!$exist_material){
				$shelf = Shelf::find($id);
				$shelf->delete();
				return Response::json(array( 'success' => true, 'problem' => false ),200);
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'exist_material' ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function delete_cubicle()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$id = Input::get('id');
			$today = Date("Y-m-d");
			$exist_reservation = CubicleReservation::where('cubicle_id','=',$id)->where('reserved_at','=',$today)->first();
			if(!$exist_reservation){
				$cubicle = Cubicle::find($id);
				$cubicle->delete();
				return Response::json(array( 'success' => true, 'problem' => false ),200);
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'exist_reservation' ),200);
			}
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}


	public function render_create_holiday(){

		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["holidays"] = Holiday::all();
				return View::make('configuration/createHoliday',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}	

	}


	public function delete_holiday_ajax(){


		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach ($selected_ids as $selected_id) {
				$holiday = Holiday::find($selected_id);	
				if($holiday){
					$holiday->delete();
				}
			}			
			
			return Response::json(array( 'success' => true, 'problem' => false ),200);
			
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}



	public function register_holiday_ajax(){


		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		if($data["staff"]->role_id == 1){
			// Check if the current user is the "System Admin"
			$date_holiday = Input::get('date_holiday');
			if($date_holiday){
				$exist_holiday = Holiday::where('date','=', $date_holiday)->first();		
				if(!$exist_holiday){
					$holiday = new Holiday; 
					$holiday->date = $date_holiday;
					$holiday->save();
				}else{
					return Response::json(array( 'success' => true, 'problem' => 'exist_holiday' ),200);
				}
			}else{
				return Response::json(array( 'success' => true, 'problem' => 'put_date' ),200);
			}
			return Response::json(array( 'success' => true, 'problem' => false ),200);
			
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

}