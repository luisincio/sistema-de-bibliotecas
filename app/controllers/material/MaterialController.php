<?php

class MaterialController extends BaseController
{
	public function render_create_material()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				// Check if the current user is the "Bibliotecario"
				$data["material_types"] = MaterialType::orderBy('name','asc')->get();
				$data["thematic_areas"] = ThematicArea::orderBy('name','asc')->get();
				$data["doners"] = Supplier::getDoners()->get();
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				
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
							'materiales_adicionales' => 'max:255',
							'suscripcion' => 'in:null,1',
							'fecha_ini' => 'required_if:suscripcion,1',
							'fecha_fin' => 'required_if:suscripcion,1|after:fecha_ini',
							'periodicidad' => 'required_if:suscripcion,1|alpha_spaces|min:2|max:45',
							'donacion' => 'in:null,1',
							'donador' => 'required_if:donacion,1|integer',
							'orden_compra' => 'required_if:donacion,null|integer',

						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('material/create_material')->withErrors($validator)->withInput(Input::all());
				}else{
					$es_donacion = Input::get('donacion');

					if($es_donacion){
						$purchase_order = false;
					}else{
						$purchase_order_id = Input::get('orden_compra');
						$purchase_order = PurchaseOrder::find($purchase_order_id);
						if(!$purchase_order){
							Session::flash('danger', 'El código de la Orden de Compra es inválido o no existe.');
							return Redirect::to('material/create_material')->withInput(Input::all());
						}
					}
					
					// Insert the material in the database
					$cant = Input::get('cant_ejemplares');
					$fecha = date_create();
					$timestamp = date_timestamp_get($fecha);
					if(Input::get('to_home') == 0){
						$to_home = 0;
					}else{
						$to_home = 1;
					}
					if(Input::get('suscripcion') == 1){
						$date_ini = Input::get('fecha_ini');
						$date_end = Input::get('fecha_fin');
						$periodicity = Input::get('periodicidad');
					}else{
						$date_ini = null;
						$date_end = null;
						$periodicity = null;
					}
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
						if($purchase_order){
							$material->doner = null;
							$material->purchase_order_id = Input::get('orden_compra');
						}else{
							$material->doner = Input::get('donador');
							$material->purchase_order_id = null;
						}
						$material->to_home = $to_home;
						$material->date_ini = $date_ini;
						$material->date_end = $date_end;
						$material->periodicity = $periodicity;
						$material->save();
					}
					Session::flash('message', 'Se registró correctamente el material.');
					return Redirect::to('material/create_material');
					
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
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
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		$data["inside_url"] = Config::get('app.inside_url');
		$data["config"] = GeneralConfiguration::first();
		if($data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
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
			$uid = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($uid)->user;
			$data["staff"] = Person::find($uid)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($id && $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				// Check if the current user is the "System Admin"
				$data["material"] = Material::find($id);
				if($data["material"]){
					$data["material_types"] = MaterialType::orderBy('name','asc')->get();
					$data["thematic_areas"] = ThematicArea::orderBy('name','asc')->get();
					$data["doner"] = Supplier::find($data["material"]->doner);
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				
				// Validate the info, create rules for the inputs
				$rules = array(
							'titulo' => 'required|min:2|max:255',
							'autor' => 'required|alpha_spaces|min:2|max:255',
							'editorial' => 'required|alpha_spaces|max:128',
							'num_edicion' => 'required|integer|min:1|max:10000',
							'anio_publicacion' => 'numeric|integer|min:1000|max:4000',
							'num_paginas' => 'required|integer|min:1|max:10000',
							'materiales_adicionales' => 'max:255',
							'suscripcion' => 'in:null,1',
							'fecha_ini' => 'required_if:suscripcion,1',
							'fecha_fin' => 'required_if:suscripcion,1|after:fecha_ini',
							'periodicidad' => 'required_if:suscripcion,1|alpha_spaces|min:2|max:45',
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
					$material->to_home = Input::get('to_home');
					if(Input::get('suscripcion') == 1){
						$date_ini = Input::get('fecha_ini');
						$date_end = Input::get('fecha_fin');
						$periodicity = Input::get('periodicidad');
					}else{
						$date_ini = null;
						$date_end = null;
						$periodicity = null;
					}
					$material->date_ini = $date_ini;
					$material->date_end = $date_end;
					$material->periodicity = $periodicity;
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
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
					Session::flash('danger','La fecha fin debe ser anterior a la fecha inicio.');
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				// Check if the current user is the "Administrador de sede" or "Bibliotecario"
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				// Check if the current user is the "Administrador de sede" or "Bibliotecario"
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
			$uid = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($uid)->user;
			$data["staff"] = Person::find($uid)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($id && $data["staff"]->role_id == 2 || $data["staff"]->role_id == 3){
				// Check if the current user is the "Administrador de sede" or "Bibliotecario"
				$data["purchase_order"] = PurchaseOrder::find($id);
				if($data["purchase_order"]){
					$supplier_id = $data["purchase_order"]->supplier_id;
					$data["suppliers"] = Supplier::find($supplier_id);					
					$data["details_purchase_orders"] = DetailsPurchaseOrder::getDetailsByPurchaseOrder($id)->get();
					
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
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			// Check if the current user is the "System Admin"
			if($data["staff"]->role_id == 2){
				// Check if the current user is the "Administrador de sede"
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
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		$data["inside_url"] = Config::get('app.inside_url');
		$data["config"] = GeneralConfiguration::first();
		if($data["staff"]->role_id == 2){
			// Check if the current user is the "Administrador de sede"
			$id = Input::get('id');
			$purchase_order = PurchaseOrder::find($id);
			$purchase_order->delete();
				
			
			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

}