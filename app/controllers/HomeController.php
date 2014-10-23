<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function home()
	{
		if(Auth::check()){
			return Redirect::to('/dashboard');
		}else{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			return View::make('login/login',$data);
		}
	}

	public function render_catalog()
	{
		if(Auth::check()){
			return Redirect::to('/catalog/catalog');
		}else{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			$data["branches"] = Branch::all();
			$data["thematic_areas"] = ThematicArea::all();
			$data["search"] = null;
			$data["search_criteria"] = null;
			$data["branch_filter"] = null;
			$data["thematic_area_filter"] = null;
			$data["materials"] = null;
			return View::make('login/catalog',$data);
		}
	}

	public function submit_catalog()
	{
		if(Auth::check()){
			return Redirect::to('/catalog/catalog');
		}else{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();
			$data["branches"] = Branch::all();
			$data["thematic_areas"] = ThematicArea::all();
			$data["search"] = Input::get('search');
			$data["search_criteria"] = $data["search"];
			$data["branch_filter"] = Input::get('branch_filter');
			$data["thematic_area_filter"] = Input::get('thematic_area_filter');
			if($data["branch_filter"] != 0 || $data["thematic_area_filter"] != 0){
				if($data["branch_filter"] != 0 && $data["thematic_area_filter"] != 0){
					$data["materials"] = Material::searchMaterialsCatalogByBranchThematic($data["search_criteria"],$data["branch_filter"],$data["thematic_area_filter"])->paginate(10);
				}elseif($data["branch_filter"] == 0 && $data["thematic_area_filter"] != 0){
					$data["materials"] = Material::searchMaterialsCatalogByThematic($data["search_criteria"],$data["thematic_area_filter"])->paginate(10);
				}elseif($data["branch_filter"] != 0 && $data["thematic_area_filter"] == 0){
					$data["materials"] = Material::searchMaterialsCatalogByBranch($data["search_criteria"],$data["branch_filter"])->paginate(10);
				}
			}else{
				$data["materials"] = Material::searchMaterialsCatalog($data["search_criteria"])->paginate(10);
			}
			return View::make('login/catalog',$data);
		}
	}

	public function material_detail_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax()){
			return Response::json(array( 'success' => false ),200);
		}
		$material_id = Input::get('material_id');
		$material = Material::find($material_id);
		return Response::json(array( 'success' => true, 'material'=>$material ),200);
	}

}
