<?php

class CatalogController extends BaseController
{
	public function render_catalog()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();

			$data["branches"] = Branch::all();
			$data["thematic_areas"] = ThematicArea::orderBy('name','asc')->get();
			$data["search"] = null;
			$data["search_criteria"] = null;
			$data["branch_filter"] = null;
			$data["thematic_area_filter"] = null;
			$data["materials"] = null;
			return View::make('catalog/catalog',$data);
		}else{
			return View::make('error/error');
		}
	}

	public function submit_catalog()
	{
		if(Auth::check()){
			$id = Auth::id();
			$data["person"] = Auth::user();
			$data["user"]= Person::find($id)->user;
			$data["staff"] = Person::find($id)->staff;
			$data["inside_url"] = Config::get('app.inside_url');
			$data["config"] = GeneralConfiguration::first();


			$data["branches"] = Branch::all();
			$data["thematic_areas"] = ThematicArea::orderBy('name','asc')->get();
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
			return View::make('catalog/catalog',$data);
		}else{
			return View::make('error/error');
		}
	}
}