<?php

class ReportController extends BaseController
{
	/* Top Loans */
	public function render_top_loans()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Date('Y-m-d');
				$data["date_end"] = Date('Y-m-d');
				$data["report_rows"] = null;
				$data["total"] = null;
				return View::make('report/topLoans',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_top_loans()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Input::get('date_ini');
				$data["date_end"] = Input::get('date_end');
				if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
					$data["report_rows"] = Loan::getTopLoansByDate($data["date_ini"],$data["date_end"])->get();
					$total = 0;
					if($data["report_rows"]->count()>0){
						foreach($data["report_rows"] as $report_row){
							$total += $report_row->loans_by_material;
						}
					}
					$data["total"] = $total;
					return View::make('report/topLoans',$data);
				}
				else{
					Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
					return Redirect::to('report/top_loans');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_top_loans_excel()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Input::get('date_ini_excel');
				$data["date_end"] = Input::get('date_end_excel');
				if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
					$data["report_rows"] = Loan::getTopLoansByDate($data["date_ini"],$data["date_end"])->get();
					// Generate the string to be rendered on excel
					$str_table = "<table><tr><td><strong>Fecha de inicio</strong></td><td>".$data["date_ini"]."</td></tr>";
					$str_table .= "<tr><td><strong>Fecha fin</strong></td><td>".$data["date_end"]."</td></tr>";
					$total = 0;
					if($data["report_rows"]->count()>0){
						foreach($data["report_rows"] as $report_row){
							$total += $report_row->loans_by_material;
						}
					}
					$str_table .= "<tr><td><strong>Total de prestamos en el periodo</strong></td><td>".$total."</td></tr><tr></tr></table>";
					$str_table .= "<table border=1><tr><th>Codigo</th><th>Titulo</th><th>Autor</th><th>Editorial</th><th>Veces prestadas</th></tr>";
					if($data["report_rows"]->count()>0){
						foreach($data["report_rows"] as $report_row){
							$str_table .= "<tr><td>".htmlentities($report_row->base_cod)."</td><td>".htmlentities($report_row->title)."</td><td>".htmlentities($report_row->author)."</td><td>".htmlentities($report_row->editorial)."</td><td>".htmlentities($report_row->loans_by_material)."</td></tr>";
						}
					}
					$str_table .= "</table>";
					$filename = "materiales_mas_prestados_".date('Y-m-d').".xls";
					// Show the download dialog
					header("Content-type: application/vnd.ms-excel; charset=utf-8");
					// Let's indicate to the browser we are giving it the file
					header("Content-Disposition: attachment; filename=\"$filename\"");
					// Avoid the browser to save the file into it's cache
					header("Pragma: no-cache");
					header("Expires: 0");
					// Render the table
					echo $str_table;
				}
				else{
					Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
					return Redirect::to('report/top_loans');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
	/* Most Requested Materials */
	public function render_most_requested_materials()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Date('Y-m-d');
				$data["date_end"] = Date('Y-m-d');
				$data["report_rows"] = null;
				$data["total"] = null;
				return View::make('report/mostRequestedMaterials',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_most_requested_materials()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Input::get('date_ini');
				$data["date_end"] = Input::get('date_end');
				if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
					$data["report_rows"] = MaterialRequest::getMostRequestedMaterialsByDate($data["date_ini"],$data["date_end"])->get();
					$total = 0;
					if($data["report_rows"]->count()>0){
						foreach($data["report_rows"] as $report_row){
							$total += $report_row->total_requests;
						}
					}
					$data["total"] = $total;
					return View::make('report/mostRequestedMaterials',$data);
				}
				else{
					Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
					return Redirect::to('report/most_requested_materials');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_most_requested_materials_excel()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Input::get('date_ini_excel');
				$data["date_end"] = Input::get('date_end_excel');
				if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
					$report_rows = MaterialRequest::getMostRequestedMaterialsByDate($data["date_ini"],$data["date_end"])->get();
					// Generate the string to be rendered on excel
					$str_table = "<table><tr><td><strong>Fecha de inicio</strong></td><td>".$data["date_ini"]."</td></tr>";
					$str_table .= "<tr><td><strong>Fecha fin</strong></td><td>".$data["date_end"]."</td></tr>";
					$total = 0;
					if($report_rows->count()>0){
						foreach($report_rows as $report_row){
							$total += $report_row->total_requests;
						}
					}
					$str_table .= "<tr><td><strong>Total de solicitudes</strong></td><td>".$total."</td></tr><tr></tr></table>";
					$str_table .= "<table border=1><tr><th>Titulo</th><th>Autor</th><th>Editorial</th><th>Edicion</th><th>Tipo de solicitud</th><th>Cantidad de solicitudes</th></tr>";
					if($report_rows->count()>0){
						foreach($report_rows as $report_row){
							$str_table .= "<tr><td>".htmlentities($report_row->title)."</td><td>".htmlentities($report_row->author)."</td><td>".htmlentities($report_row->editorial)."</td><td>".htmlentities($report_row->edition)."</td><td>".htmlentities($report_row->name)."</td><td>".htmlentities($report_row->total_requests)."</td></tr>";
						}
					}
					$str_table .= "</table>";
					$filename = "materiales_mas_solicitados_".date('Y-m-d').".xls";
					// Show the download dialog
					header("Content-type: application/vnd.ms-excel; charset=utf-8");
					// Let's indicate to the browser we are giving it the file
					header("Content-Disposition: attachment; filename=\"$filename\"");
					// Avoid the browser to save the file into it's cache
					header("Pragma: no-cache");
					header("Expires: 0");
					// Render the table
					echo $str_table;
				}
				else{
					Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
					return Redirect::to('report/most_requested_materials');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	/* Restricted Users */
	public function render_restricted_users()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["restricted_users"] = User::getRestrictedUsers()->get();
				$data["total_restricted_users"] = $data["restricted_users"]->count();
				return View::make('report/restrictedUsers',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_restricted_users_excel()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$restricted_users = User::getRestrictedUsers()->get();
				$total_restricted_users = $restricted_users->count();
				
				$str_table = "<table><tr><td><strong>Total de usuarios con multa</strong></td><td>".$total_restricted_users."</td></tr><tr></tr></table>";
				$str_table .= "<table border=1><tr><th>Num. Documento</th><th>Nombres</th><th>Apellidos</th><th>E-mail</th><th>Direccion</th><th>Telefono</th><th>Genero</th><th>Fecha de re-incorporacion</th></tr>";
				if($total_restricted_users > 0){
					foreach($restricted_users as $restricted_user){
						$str_table .= "<tr><td>".htmlentities($restricted_user->doc_number)."</td><td>".htmlentities($restricted_user->name)."</td><td>".htmlentities($restricted_user->lastname)."</td><td>".htmlentities($restricted_user->mail)."</td><td>".htmlentities($restricted_user->address)."</td><td>".htmlentities($restricted_user->phone)."</td><td>".htmlentities($restricted_user->gender)."</td><td>".htmlentities($restricted_user->restricted_until)."</td></tr>";
					}
				}
				$str_table .= "</table>";

				$filename = "usuarios_con_multa_".date('Y-m-d').".xls";
				// Show the download dialog
				header("Content-type: application/vnd.ms-excel; charset=utf-8");
				// Let's indicate to the browser we are giving it the file
				header("Content-Disposition: attachment; filename=\"$filename\"");
				// Avoid the browser to save the file into it's cache
				header("Pragma: no-cache");
				header("Expires: 0");
				// Render the table
				echo $str_table;

			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
	/* Loans By User */
	public function render_loans_by_user()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["num_doc"] = null;
				$data["date_ini"] = Date('Y-m-d');
				$data["date_end"] = Date('Y-m-d');
				$data["report_rows"] = null;
				$data["report_rows_detailed"] = null;
				$data["total"] = null;
				return View::make('report/loansByUser',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_loans_by_user()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				// Validate the info, create rules for the inputs
				$rules = array(
							'num_doc' => 'required|numeric|min:9999999|max:999999999999'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('report/loans_by_user')->withErrors($validator)->withInput(Input::all());
				}else{
					$data["num_doc"] = Input::get('num_doc');
					$person = Person::searchPersonByDocument($data["num_doc"])->first();
					if($person){
						$user = User::searchUserByPerson($person->id)->first();
						if($user){
							$data["date_ini"] = Input::get('date_ini');
							$data["date_end"] = Input::get('date_end');
							if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
								$data["report_rows"] = Loan::getLoansByUserDate($user->id,$data["date_ini"],$data["date_end"])->get();
								$data["report_rows_detailed"] = Loan::getLoansByUserDateDetailed($user->id,$data["date_ini"],$data["date_end"])->get();
								$data["total"] = $data["report_rows_detailed"]->count();
								return View::make('report/loansByUser',$data);
							}
							else{
								Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
								return Redirect::to('report/loans_by_user');
							}
						}else{
							Session::flash('danger','No existe usuario asociado a dicho número de documento.');
							return Redirect::to('report/loans_by_user');
						}
					}else{
						Session::flash('danger','No existe información de alguna persona con dicho número de documento.');
						return Redirect::to('report/loans_by_user');
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_loans_by_user_excel()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				// Validate the info, create rules for the inputs
				$rules = array(
							'num_doc_excel' => 'required|numeric|min:9999999|max:999999999999'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('report/loans_by_user')->withErrors($validator)->withInput(Input::all());
				}else{
					$data["num_doc"] = Input::get('num_doc_excel');
					$person = Person::searchPersonByDocument($data["num_doc"])->first();
					if($person){
						$user = User::searchUserByPerson($person->id)->first();
						if($user){
							$data["date_ini"] = Input::get('date_ini_excel');
							$data["date_end"] = Input::get('date_end_excel');
							if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
								$data["report_rows"] = Loan::getLoansByUserDate($user->id,$data["date_ini"],$data["date_end"])->get();
								$data["report_rows_detailed"] = Loan::getLoansByUserDateDetailed($user->id,$data["date_ini"],$data["date_end"])->get();
								$data["total"] = $data["report_rows_detailed"]->count();

								// Generate the string to be rendered on excel
								$str_table = "<table><tr><td><strong>Usuario</strong></td><td>".$person->name." ".$person->lastname."(".$person->doc_number.")"."</td></tr>";
								$str_table .= "<tr><td><strong>Fecha de inicio</strong></td><td>".$data["date_ini"]."</td><tr><td><strong>Fecha fin</strong></td><td>".$data["date_end"]."</td></tr>";
								$str_table .= "<tr><td><strong>Total de prestamos en el periodo</strong></td><td>".$data["total"]."</td></tr><tr></tr></table>";

								$str_table .= "<table border=1><tr><td><strong>Resumen de prestamos</strong></td></tr><tr><th>Codigo(4 letras)</th><th>Titulo</th><th>Autor</th><th>Editorial</th><th>Veces prestadas</th></tr>";
								if($data["report_rows"]->count()>0){
									foreach($data["report_rows"] as $report_row){
										$str_table .= "<tr><td>".htmlentities($report_row->base_cod)."</td><td>".htmlentities($report_row->title)."</td><td>".htmlentities($report_row->author)."</td><td>".htmlentities($report_row->editorial)."</td><td>".htmlentities($report_row->loans_by_material)."</td></tr>";
									}
								}
								$str_table .= "</table>";

								$str_table .= "<table><tr></tr><tr></tr><tr></tr></table>";

								$str_table .= "<table border=1><tr><td><strong>Detalle de prestamos</strong></td></tr><tr><th>Codigo(4 letras)</th><th>Codigo completo</th><th>Titulo</th><th>Autor</th><th>Editorial</th><th>Fecha y hora de prestamo</th></tr>";
								if($data["report_rows_detailed"]->count()>0){
									foreach($data["report_rows_detailed"] as $report_row){
										$str_table .= "<tr><td>".htmlentities($report_row->base_cod)."</td><td>".htmlentities($report_row->auto_cod)."</td><td>".htmlentities($report_row->title)."</td><td>".htmlentities($report_row->author)."</td><td>".htmlentities($report_row->editorial)."</td><td>".htmlentities($report_row->created_at)."</td></tr>";
									}
								}
								$str_table .= "</table>";
								$filename = "prestamos_de_".$person->name." ".$person->lastname."_".date('Y-m-d').".xls";
								// Show the download dialog
								header("Content-type: application/vnd.ms-excel; charset=utf-8");
								// Let's indicate to the browser we are giving it the file
								header("Content-Disposition: attachment; filename=\"$filename\"");
								// Avoid the browser to save the file into it's cache
								header("Pragma: no-cache");
								header("Expires: 0");
								// Render the table
								echo $str_table;
							}
							else{
								Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
								return Redirect::to('report/loans_by_user');
							}
						}else{
							Session::flash('danger','No existe usuario asociado a dicho número de documento.');
							return Redirect::to('report/loans_by_user');
						}
					}else{
						Session::flash('danger','No existe información de alguna persona con dicho número de documento.');
						return Redirect::to('report/loans_by_user');
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	/* Last Material Entries */
	public function render_last_material_entries()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Date('Y-m-d');
				$data["date_end"] = Date('Y-m-d');
				$data["report_rows"] = null;
				$data["total"] = null;
				return View::make('report/lastMaterialEntries',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_last_material_entries()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Input::get('date_ini');
				$data["date_end"] = Input::get('date_end');
				if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
					$data["report_rows"] = Material::getLastBookEntriesByDate($data["date_ini"],$data["date_end"])->get();
					$total = 0;
					if($data["report_rows"]->count()>0){
						foreach($data["report_rows"] as $report_row){
							$total += $report_row->total_entries;
						}
					}
					$data["total"] = $total;
					return View::make('report/lastMaterialEntries',$data);
				}
				else{
					Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
					return Redirect::to('report/last_material_entries');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_last_material_entries_excel()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Input::get('date_ini_excel');
				$data["date_end"] = Input::get('date_end_excel');
				if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
					$report_rows = Material::getLastBookEntriesByDate($data["date_ini"],$data["date_end"])->get();
					// Generate the string to be rendered on excel
					$str_table = "<table><tr><td><strong>Fecha de inicio</strong></td><td>".$data["date_ini"]."</td></tr>";
					$str_table .= "<tr><td><strong>Fecha fin</strong></td><td>".$data["date_end"]."</td></tr>";
					$total = 0;
					if($report_rows->count()>0){
						foreach($report_rows as $report_row){
							$total += $report_row->total_entries;
						}
					}
					$str_table .= "<tr><td><strong>Total de libros</strong></td><td>".$total."</td></tr><tr></tr></table>";
					$str_table .= "<table border=1><tr><th>Codigo base</th><th>ISBN</th><th>Titulo</th><th>Autor</th><th>Editorial</th><th>Edicion</th><th>Cantidad</th></tr>";
					if($report_rows->count()>0){
						foreach($report_rows as $report_row){
							$str_table .= "<tr><td>".htmlentities($report_row->base_cod)."</td><td>".htmlentities($report_row->isbn)."</td><td>".htmlentities($report_row->title)."</td><td>".htmlentities($report_row->author)."</td><td>".htmlentities($report_row->editorial)."</td><td>".htmlentities($report_row->edition)."</td><td>".htmlentities($report_row->total_entries)."</td></tr>";
						}
					}
					$str_table .= "</table>";
					$filename = "libros_ingresados_".date('Y-m-d').".xls";
					// Show the download dialog
					header("Content-type: application/vnd.ms-excel; charset=utf-8");
					// Let's indicate to the browser we are giving it the file
					header("Content-Disposition: attachment; filename=\"$filename\"");
					// Avoid the browser to save the file into it's cache
					header("Pragma: no-cache");
					header("Expires: 0");
					// Render the table
					echo $str_table;
				}
				else{
					Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
					return Redirect::to('report/last_material_entries');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
	/* Loans By Material */
	public function render_loans_by_material()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["code"] = null;
				$data["date_ini"] = Date('Y-m-d');
				$data["date_end"] = Date('Y-m-d');
				$data["report_rows"] = null;
				$data["report_rows_detailed"] = null;
				$data["total"] = null;
				$data["material_title"] = null;
				$data["total_users"] = null;
				return View::make('report/loansByMaterial',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_loans_by_material()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				// Validate the info, create rules for the inputs
				$rules = array(
							'code' => 'required|alpha|min:4|max:4'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('report/loans_by_material')->withErrors($validator)->withInput(Input::all());
				}else{
					$data["code"] = Input::get('code');
					$material = Material::searchMaterialByCode($data["code"])->first();
					if($material){
						$data["date_ini"] = Input::get('date_ini');
						$data["date_end"] = Input::get('date_end');
						if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
							$data["report_rows"] = Loan::getLoansByMaterialDate($data["code"],$data["date_ini"],$data["date_end"])->get();
							$data["report_rows_detailed"] = Loan::getLoansByMaterialDateDetailed($data["code"],$data["date_ini"],$data["date_end"])->get();
							$data["total"] = $data["report_rows_detailed"]->count();
							$data["material_title"] = $material->title;
							$data["total_users"] = $data["report_rows"]->count();
							return View::make('report/loansByMaterial',$data);
						}
						else{
							Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
							return Redirect::to('report/loans_by_user');
						}
					}else{
						Session::flash('danger','No existe materiales con dicho código.');
						return Redirect::to('report/loans_by_user');
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_loans_by_material_excel()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				// Validate the info, create rules for the inputs
				$rules = array(
							'code_excel' => 'required|alpha|min:4|max:4'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('report/loans_by_material')->withErrors($validator)->withInput(Input::all());
				}else{
					$data["code"] = Input::get('code_excel');
					$material = Material::searchMaterialByCode($data["code"])->first();
					if($material){
						$data["date_ini"] = Input::get('date_ini_excel');
						$data["date_end"] = Input::get('date_end_excel');
						if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
							$data["report_rows"] = Loan::getLoansByMaterialDate($data["code"],$data["date_ini"],$data["date_end"])->get();
							$data["report_rows_detailed"] = Loan::getLoansByMaterialDateDetailed($data["code"],$data["date_ini"],$data["date_end"])->get();
							$data["total"] = $data["report_rows_detailed"]->count();
							$data["total_users"] = $data["report_rows"]->count();
							

							// Generate the string to be rendered on excel
							$str_table = "<table><tr><td><strong>Titulo del material</strong></td><td>".htmlentities($material->title)."(".htmlentities($material->base_cod).")"."</td></tr>";
							$str_table .= "<tr><td><strong>Fecha de inicio</strong></td><td>".$data["date_ini"]."</td><tr><td><strong>Fecha fin</strong></td><td>".$data["date_end"]."</td></tr>";
							$str_table .= "<tr><td><strong>Total de usuarios a los que se le presto el material</strong></td><td>".$data["total_users"]."</td></tr><tr></tr>";
							$str_table .= "<tr><td><strong>Total de prestamos en el periodo</strong></td><td>".$data["total"]."</td></tr><tr></tr></table>";

							$str_table .= "<table border=1><tr><td><strong>Resumen de prestamos</strong></td></tr><tr><th>Numero de Documento</th><th>Nombres</th><th>Apellidos</th><th>E-mail</th><th>Veces prestadas</th></tr>";
							if($data["report_rows"]->count()>0){
								foreach($data["report_rows"] as $report_row){
									$str_table .= "<tr><td>".htmlentities($report_row->doc_number)."</td><td>".htmlentities($report_row->name)."</td><td>".htmlentities($report_row->lastname)."</td><td>".htmlentities($report_row->mail)."</td><td>".htmlentities($report_row->loans_by_user)."</td></tr>";
								}
							}
							$str_table .= "</table>";

							$str_table .= "<table><tr></tr><tr></tr><tr></tr></table>";

							$str_table .= "<table border=1><tr><td><strong>Detalle de prestamos</strong></td></tr><tr><th>Numero de Documento</th><th>Nombres</th><th>Apellidos</th><th>E-mail</th><th>Fecha y hora de prestamo</th></tr>";
							if($data["report_rows_detailed"]->count()>0){
								foreach($data["report_rows_detailed"] as $report_row){
									$str_table .= "<tr><td>".htmlentities($report_row->doc_number)."</td><td>".htmlentities($report_row->name)."</td><td>".htmlentities($report_row->lastname)."</td><td>".htmlentities($report_row->mail)."</td><td>".htmlentities($report_row->created_at)."</td></tr>";
								}
							}
							$str_table .= "</table>";
							$filename = "reporte_del_material_".$material->title."_".date('Y-m-d').".xls";
							// Show the download dialog
							header("Content-type: application/vnd.ms-excel; charset=utf-8");
							// Let's indicate to the browser we are giving it the file
							header("Content-Disposition: attachment; filename=\"$filename\"");
							// Avoid the browser to save the file into it's cache
							header("Pragma: no-cache");
							header("Expires: 0");
							// Render the table
							echo $str_table;


						}
						else{
							Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
							return Redirect::to('report/loans_by_user');
						}
					}else{
						Session::flash('danger','No existe materiales con dicho código.');
						return Redirect::to('report/loans_by_user');
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
	/* Approved/Rejected Purchase Orders */
	public function render_approved_rejected_purchase_orders()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Date('Y-m-d');
				$data["date_end"] = Date('Y-m-d');
				$data["report_rows_approved"] = null;
				$data["report_rows_rejected"] = null;
				$data["total_approved"] = null;
				$data["total_rejected"] = null;
				$data["total_amount_approved"] = null;
				$data["total_amount_rejected"] = null;
				$data["total"] = null;
				return View::make('report/approvedRejectedPurchaseOrders',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_approved_rejected_purchase_orders()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Input::get('date_ini');
				$data["date_end"] = Input::get('date_end');
				if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
					$data["report_rows_approved"] = PurchaseOrder::getApprovedPurchaseOrdersByDate($data["date_ini"],$data["date_end"])->get();
					$data["total_approved"] = 0;
					$data["total_amount_approved"] = 0;
					if($data["report_rows_approved"]->count()>0){
						foreach($data["report_rows_approved"] as $report_row_approved){
							$data["total_approved"] += 1;
							$data["total_amount_approved"] += $report_row_approved->total_amount;
						}
					}
					$data["report_rows_rejected"] = PurchaseOrder::getRejectedPurchaseOrdersByDate($data["date_ini"],$data["date_end"])->get();
					$data["total_rejected"] = 0;
					$data["total_amount_rejected"] = 0;
					if($data["report_rows_rejected"]->count()>0){
						foreach($data["report_rows_rejected"] as $report_row_rejected){
							$data["total_rejected"] += 1;
							$data["total_amount_rejected"] += $report_row_rejected->total_amount;
						}
					}
					$data["total"] = $data["total_approved"] + $data["total_rejected"];
					return View::make('report/approvedRejectedPurchaseOrders',$data);
				}
				else{
					Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
					return Redirect::to('report/approved_rejected_purchase_orders');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_approved_rejected_purchase_orders_excel()
	{
		if(Auth::check()){
			$data["person"] = Session::get('person');
			$data["user"] = Session::get('user');
			$data["staff"] = Session::get('staff');
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			if($data["staff"]->role_id == 1){
				// Check if the current user is the "System Admin"
				$data["date_ini"] = Input::get('date_ini_excel');
				$data["date_end"] = Input::get('date_end_excel');
				if( strtotime($data["date_ini"]) <= strtotime($data["date_end"]) ){
					$data["report_rows_approved"] = PurchaseOrder::getApprovedPurchaseOrdersByDate($data["date_ini"],$data["date_end"])->get();
					$data["total_approved"] = 0;
					$data["total_amount_approved"] = 0;
					if($data["report_rows_approved"]->count()>0){
						foreach($data["report_rows_approved"] as $report_row_approved){
							$data["total_approved"] += 1;
							$data["total_amount_approved"] += $report_row_approved->total_amount;
						}
					}
					$data["report_rows_rejected"] = PurchaseOrder::getRejectedPurchaseOrdersByDate($data["date_ini"],$data["date_end"])->get();
					$data["total_rejected"] = 0;
					$data["total_amount_rejected"] = 0;
					if($data["report_rows_rejected"]->count()>0){
						foreach($data["report_rows_rejected"] as $report_row_rejected){
							$data["total_rejected"] += 1;
							$data["total_amount_rejected"] += $report_row_rejected->total_amount;
						}
					}
					$data["total"] = $data["total_approved"] + $data["total_rejected"];

					// Generate the string to be rendered on excel
					$str_table = "<table><tr><td><strong>Fecha de inicio</strong></td><td>".$data["date_ini"]."</td></tr>";
					$str_table .= "<tr><td><strong>Fecha fin</strong></td><td>".$data["date_end"]."</td></tr>";
					$str_table .= "<tr><td><strong>Total de solicitudes aprobadas</strong></td><td>".$data["total_approved"]."</td><td><strong>Total de solicitudes rechazadas</strong></td><td>".$data["total_rejected"]."</td></tr>";
					$str_table .= "<tr><td><strong>Costo total de solicitudes aprobadas (S/.)</strong></td><td>".$data["total_amount_approved"]."</td><td><strong>Costo total de solicitudes rechazadas (S/.)</strong></td><td>".$data["total_amount_rejected"]."</td></tr>";
					$str_table .= "<tr><td><strong>Total de solicitudes</strong></td><td>".$data["total"]."</td></tr><tr></tr>";

					$str_table .= "<table border=1><tr><th>ID</th><th>Fecha de emision</th><th>Fecha de expiracion</th><th>Descripcion</th><th>Proveedor</th><th>Costo total</th><th>Estado</th></tr>";
					if($data["report_rows_approved"]->count()>0){
						foreach($data["report_rows_approved"] as $report_row){
							$str_table .= "<tr><td>".htmlentities($report_row->id)."</td><td>".htmlentities($report_row->date_issue)."</td><td>".htmlentities($report_row->expire_at)."</td><td>".htmlentities($report_row->description)."</td><td>".htmlentities($report_row->name)."</td><td>".htmlentities($report_row->total_amount)."</td><td>Aprobado</td></tr>";
						}
					}
					if($data["report_rows_rejected"]->count()>0){
						foreach($data["report_rows_rejected"] as $report_row){
							$str_table .= "<tr><td>".htmlentities($report_row->id)."</td><td>".htmlentities($report_row->date_issue)."</td><td>".htmlentities($report_row->expire_at)."</td><td>".htmlentities($report_row->description)."</td><td>".htmlentities($report_row->name)."</td><td>".htmlentities($report_row->total_amount)."</td><td>Rechazado</td></tr>";
						}
					}
					$str_table .= "</table>";
					$filename = "solicitudes_compra_".date('Y-m-d').".xls";
					// Show the download dialog
					header("Content-type: application/vnd.ms-excel; charset=utf-8");
					// Let's indicate to the browser we are giving it the file
					header("Content-Disposition: attachment; filename=\"$filename\"");
					// Avoid the browser to save the file into it's cache
					header("Pragma: no-cache");
					header("Expires: 0");
					// Render the table
					echo $str_table;
				}
				else{
					Session::flash('danger','La fecha de inicio es mayor a la fecha final.');
					return Redirect::to('report/approved_rejected_purchase_orders');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
}