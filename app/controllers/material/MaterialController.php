<?php

class MaterialController extends BaseController
{
	public function render_create_material()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "Bibliotecario"
				$data["material_types"] = MaterialType::all();
				$data["thematic_areas"] = ThematicArea::all();
				$turn_id = $data["staff"]->turn_id;
				$turn = Turn::find($turn_id);
				$branch_id = $turn->branch_id;
				$data["shelves"] = Shelf::getShelvesByBranch($branch_id)->get();
				return View::make('material/createMaterial',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_material()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 3){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'titulo' => 'required|min:2',
							'codigo' => 'required|alpha|min:4|max:4',
							'autor' => 'required|alpha_spaces|min:2',
							'editorial' => 'required|alpha_spaces',
							'num_edicion' => 'required|numeric|min:1|max:10000',
							'isbn' => 'required|alpha_num|min:10|max:14',
							'anio_publicacion' => 'numeric|min:1000|max:2014',
							'num_paginas' => 'required|numeric|min:1|max:10000',
							'cant_ejemplares' => 'required|numeric|min:1|max:10000',
							'orden_compra' => 'required|numeric',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('material/create_material')->withErrors($validator)->withInput(Input::all());
				}else{
					// Insert the material in the database
					$cant = Input::get('cant_ejemplares');
					$fecha = date_create();
					$timestamp = date_timestamp_get($fecha);
					for($i=0;$i<$cant;$i++){
						$auto_cod = Input::get('codigo').($timestamp);
						$timestamp++;
						$material = new Material;
						$material->title = Input::get('titulo');
						$material->auto_cod = $auto_cod;
						$material->author = Input::get('autor');
						$material->editorial = Input::get('editorial');
						$material->additional_materials = Input::get('materiales_adicionales');
						$material->num_pages = Input::get('num_paginas');
						$material->edition = Input::get('num_edicion');
						$material->publication_year = Input::get('anio_publicacion');
						$material->isbn = Input::get('isbn');
						$material->subscription = Input::get('suscripcion');
						$material->material_type = Input::get('tipo_material');
						$material->thematic_area = Input::get('area_tematica');
						$material->shelve_id = Input::get('estante');
						$material->purchase_order_id = Input::get('orden_compra');
						$material->save();
					}

					Session::flash('message', 'Se registró correctamente el material.');
					return Redirect::to('material/createMaterial');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_material()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "System Admin"
				$data["search_criteria"] = null;
				//$data["materials"] = Material::paginate(20);
				$turn_id = $data["staff"]->turn_id;
				$turn = Turn::find($turn_id);
				$branch_id = $turn->branch_id;
				$data["materials"] = Material::getMaterialsByBranch($branch_id)->paginate(10);

				$data["search"] = null;
				$data["thematic_areas"] = ThematicArea::all();
				return View::make('material/listMaterial',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_material()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "System Admin"
				$data["search_criteria"] = Input::get('search');
				$data["search_filter"] = Input::get('search_filter');
				$turn_id = $data["staff"]->turn_id;
				$turn = Turn::find($turn_id);
				$branch_id = $turn->branch_id;
				if($data["search_filter"] == 0){
					$data["materials"] = Material::searchMaterialsByBranch($branch_id,$data["search_criteria"])->paginate(10);
				}else{
					$data["materials"] = Material::searchMaterialsByBranchByFilter($branch_id,$data["search_criteria"],$data["search_filter"])->paginate(10);
				}
				$data["search"] = $data["search_criteria"];
				$data["thematic_areas"] = ThematicArea::all();
				return View::make('material/listMaterial',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function delete_material_ajax()
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
			// Check if the current user is the "System Admin"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$material = Material::find($selected_id);
				$material->delete();
			}
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_edit_material($id=null)
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3 && $id){
				// Check if the current user is the "System Admin"
				$data["material"] = Material::find($id);
				if($data["material"]){
					$data["material_types"] = MaterialType::all();
					$data["thematic_areas"] = ThematicArea::all();
					$turn_id = $data["staff"]->turn_id;
					$turn = Turn::find($turn_id);
					$branch_id = $turn->branch_id;
					$data["shelves"] = Shelf::getShelvesByBranch($branch_id)->get();
					return View::make('material/editMaterial',$data);
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

	public function submit_edit_material()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 3){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'titulo' => 'required|min:2',
							'autor' => 'required|alpha_spaces|min:2',
							'editorial' => 'required|alpha_spaces',
							'num_edicion' => 'required|numeric|min:1|max:10000',
							'anio_publicacion' => 'numeric|min:1000|max:2014',
							'num_paginas' => 'required|numeric|min:1|max:10000',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$url = 'material/edit_material/'.Input::get('id');
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					// Insert the material in the database
					$id = Input::get('id');
					$url = 'material/edit_material/'.$id;
					$material = Material::find($id);
					$material->title = Input::get('titulo');
					$material->author = Input::get('autor');
					$material->editorial = Input::get('editorial');
					$material->additional_materials = Input::get('materiales_adicionales');
					$material->num_pages = Input::get('num_paginas');
					$material->edition = Input::get('num_edicion');
					$material->publication_year = Input::get('anio_publicacion');
					$material->subscription = Input::get('suscripcion');
					$material->thematic_area = Input::get('area_tematica');
					$material->shelve_id = Input::get('estante');
					$material->save();

					Session::flash('message', 'Se editó correctamente el material.');
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