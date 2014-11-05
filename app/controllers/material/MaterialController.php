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
							'titulo' => 'required|min:2|max:255',
							'codigo' => 'required|alpha|min:4|max:4',
							'autor' => 'required|alpha_spaces|min:2|max:255',
							'editorial' => 'required|alpha_spaces|max:128',
							'num_edicion' => 'required|integer|min:1|max:10000',
							'isbn' => 'required|alpha_num|min:10|max:14',
							'anio_publicacion' => 'numeric|integer|min:1000|max:4000',
							'num_paginas' => 'required|integer|min:1|max:10000',
							'cant_ejemplares' => 'required|integer|min:1|max:10000',
							'orden_compra' => 'required|integer',
							'materiales_adicionales' => 'max:255',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('material/create_material')->withErrors($validator)->withInput(Input::all());
				}else{
					// Check if the purchase order exists
					$purchase_order_id = Input::get('orden_compra');
					$purchase_order = PurchaseOrder::find($purchase_order_id);
					if($purchase_order){
						// Insert the material in the database
						$cant = Input::get('cant_ejemplares');
						$fecha = date_create();
						$timestamp = date_timestamp_get($fecha);
						for($i=0;$i<$cant;$i++){
							$auto_cod = Input::get('codigo').($timestamp);
							$timestamp++;
							$material = new Material;
							$material->title = Input::get('titulo');
							$material->base_cod = Input::get('codigo');
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
						return Redirect::to('material/create_material');
					}else{
						Session::flash('danger', 'El código de la Orden de Compra es inválido.');
						return Redirect::to('material/create_material')->withInput(Input::all());
					}
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
				$data["search_filter"] = null;
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
			// Check if the current user is the "Bibliotecario"
			$selected_ids = Input::get('selected_id');
			foreach($selected_ids as $selected_id){
				$material = Material::find($selected_id);
				if($material){
					$has_loans = Loan::where('material_id','=',$material->mid)->first();
					$has_reservation = MaterialReservation::where('material_id','=',$material->mid)->first();
					if(!$has_loans && !$has_reservation){
						$material->delete();
					}
				}
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
							'titulo' => 'required|min:2|max:255',
							'autor' => 'required|alpha_spaces|min:2|max:255',
							'editorial' => 'required|alpha_spaces|max:128',
							'num_edicion' => 'required|integer|min:1|max:10000',
							'anio_publicacion' => 'numeric|integer|min:1000|max:4000',
							'num_paginas' => 'required|integer|min:1|max:10000',
							'materiales_adicionales' => 'max:255',
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

	public function list_material_request()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "System Admin"				
				$data["material_request_types"] = MaterialRequestType::all();
				$data["search_criteria"] = null;				
				$data["materials_request"] = MaterialRequest::getMaterialsRequest()->paginate(10);
				$data["search"] = null;
				$data["search_filter"] = null;
				$data["date_ini"] = null;
				$data["date_end"] = null;
				return View::make('material/listMaterialRequest',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_material_request()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Input::get('date_ini');
				$data["date_end"] = Input::get('date_end');
				if( strtotime($data["date_ini"])< strtotime($data["date_end"]) ){
					$data["search_criteria"] = Input::get('search');
					$data["search_filter"] = Input::get('search_filter');
					
					$data["material_request_types"] = MaterialRequestType::all();
					if($data["search_filter"] == 0){
						$data["materials_request"] = MaterialRequest::searchMaterialsRequest($data["search_criteria"],$data["date_ini"],$data["date_end"])->paginate(10);
					}else{
						$data["materials_request"] = MaterialRequest::searchMaterialsRequestByFilter($data["search_criteria"],$data["search_filter"],$data["date_ini"],$data["date_end"])->paginate(10);
					}
					$data["search"] = $data["search_criteria"];
					return View::make('material/listMaterialRequest',$data);
				}
				else{
					Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
					return Redirect::to('material/list_material_request');
				}				
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}

	}

	public function render_create_purchase_order()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "Bibliotecario"
				$data["suppliers"] = Supplier::all();			
				$data["purchase_orders"] = PurchaseOrder::all();
				$data["details_purchase_orders"]= DetailsPurchaseOrder::all();
				return View::make('material/createPurchaseOrder',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}



	public function submit_create_purchase_order()
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
							'descripcion' => 'required|min:2|max:255',
							'femision' => 'required|min:1',
							'fecha_vencimiento' => 'required|min:1',							
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('material/create_purchase_order')->withErrors($validator)->withInput(Input::all());
				}else{
						
					$fecha_emision = Input::get('femision');
					$fecha_vencimiento = Input::get('fecha_vencimiento');

					if(strtotime($fecha_emision) < strtotime($fecha_vencimiento)){

						// Insert the material in the database
						$details_code =Input::get('details_code');
						$details_title =Input::get('details_title'); 
						$details_author =Input::get('details_author'); 
						$details_quantity =Input::get('details_quantity'); 
						$details_unit_price =Input::get('details_unit_price');  
						$cant = count($details_code);
						if($cant>0){
							$purchase_order = new PurchaseOrder;
							$fecha = date_create();
							$timestamp = date_timestamp_get($fecha);
							//Para obtener el total del precio precio
							$total_amount = 0;
							for($i=0;$i<$cant;$i++){
								//Aumento el total precio
								$total_amount += $details_quantity[$i]*$details_unit_price[$i];
							}
							//Insert the purchase order in the database
							$purchase_order->date_issue = $fecha_emision;
							$purchase_order->expire_at = $fecha_vencimiento;
							$purchase_order->description = Input::get('descripcion');
							$purchase_order->state = 0;
							$purchase_order->total_amount = $total_amount;
							$purchase_order->supplier_id = Input::get('proveedor');
							$purchase_order->save();

							for($i=0;$i<$cant;$i++){
								//$auto_cod = Input::get('codigo').($timestamp);
								//$timestamp++;
								$details_purchase_order = new DetailsPurchaseOrder;
								$details_purchase_order->code = $details_code[$i];
								$details_purchase_order->title = $details_title[$i];
								$details_purchase_order->author = $details_author[$i];
								$details_purchase_order->quantity = $details_quantity[$i];
								$details_purchase_order->price = $details_unit_price[$i];						
								$details_purchase_order->purchase_order_id = $purchase_order->id;	
								$details_purchase_order->save();

							}
							Session::flash('message', 'Se registró correctamente la orden de compra.');
							return Redirect::to('material/create_purchase_order');
						}else{
							Session::flash('danger', 'Ingrese por lo menos un material.');
							return Redirect::to('material/create_purchase_order');		
						}																											
					}else{

						Session::flash('danger', 'La fecha de vencimiento es menor a la fecha de emisión.');
						return Redirect::to('material/create_purchase_order')->withInput(Input::all());
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function list_purchase_order()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "System Admin"
				$data["purchase_orders"] = PurchaseOrder::getPurchaseOrderInfo()->paginate(10);
				$data["date_ini"] = null;
				$data["date_end"] = null;
				
				return View::make('material/listPurchaseOrder',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}		

	
	public function search_purchase_order()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3){
				// Check if the current user is the "System Admin"
				$fecha_emision	= Input::get('fecha_emision');					
				$fecha_vencimiento = Input::get('fecha_vencimiento');
				$data["purchase_orders"] = PurchaseOrder::searchPurchaseOrderByDate($fecha_emision,$fecha_vencimiento)->paginate(10);
				
				$data["date_ini"] = $fecha_emision;
				$data["date_end"] = $fecha_vencimiento;
				return View::make('material/listPurchaseOrder',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function render_edit_purchase_order($id=null)
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 3 && $id){
				// Check if the current user is the "System Admin"
				$data["purchase_order"] = PurchaseOrder::find($id);
				if($data["purchase_order"]){
					$supplier_id = $data["purchase_order"]->supplier_id;
					$data["suppliers"] = Supplier::find($supplier_id);					
					$data["details_purchase_orders"] = DetailsPurchaseOrder::getDetailsByPurchaseOrder($id)->get();
					//$data["thematic_areas"] = ThematicArea::all();
					
					return View::make('material/editPurchaseOrder',$data);
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


	public function submit_edit_purchase_order()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 3){
				// Insert the material in the database
				$id = Input::get('id');
				$url = 'material/edit_purchase_order/'.$id;
				$purchase_order = PurchaseOrder::find($id);
				$purchase_order->state = 1;
				$purchase_order->save();

				Session::flash('message', 'Se aprobó la orden de compra.');
				return Redirect::to($url);
				
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}


	public function submit_reject_purchase_order_ajax()
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
			$id = Input::get('id');
			
			$purchase_order = PurchaseOrder::find($id);
			
			$purchase_order->delete();
				
			
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

}