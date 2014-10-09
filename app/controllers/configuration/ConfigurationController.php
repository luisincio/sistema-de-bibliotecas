<?php

class ConfigurationController extends BaseController
{
	public function render_create_supplier()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|unique:suppliers,name',
							'ruc' => 'required|numeric|min:10|unique:suppliers,ruc',
							'representante' => 'required|alpha_spaces|min:2',
							'direccion' => 'required',
							'telefono' => 'numeric',
							'celular' => 'numeric',
							'email' => 'required|email',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('config/create_supplier')->withErrors($validator)->withInput(Input::all());
				}else{
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'representante' => 'required|alpha_spaces|min:2',
							'direccion' => 'required',
							'telefono' => 'numeric',
							'celular' => 'numeric',
							'email' => 'required|email',
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2',
							'ruc' => 'required|numeric|min:10',
							'direccion' => 'required',
							'logo' => 'image',
							'tiempo_maximo_prestamo_cubiculo' => 'required|numeric|max:4',
							'tiempo_suspencion' => 'required|numeric|max:90',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('config/general_configuration')->withErrors($validator);
				}else{
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
					$config->time_suspencion = Input::get('tiempo_suspencion');
					$config->save();

					Session::flash('message', 'Se modificó correctamente la configuración general.');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|alpha_spaces|min:2|unique:material_types,name',
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
		$data["person"] = Session::get('person');
		$data["user"] = Session::get('user');
		$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
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
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 1){
				// Edit the material_type in the database
				Input::merge(array_map('trim', Input::all()));
				$id = Input::get('id');
				$url = 'config/edit_material_type/'.$id;
				$material_type = MaterialType::find($id);
				$material_type->description = Input::get('descripcion');
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
}