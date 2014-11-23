<?php


use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Material extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $primaryKey = 'mid';

	public function scopeGetMaterialsByBranch($query,$branch_id)
	{
		$query->join('shelves','materials.shelve_id','=','shelves.id')
			  ->where('shelves.branch_id','=',$branch_id);
		return $query;
	}

	public function scopeSearchMaterialsByBranch($query,$branch_id,$search_criteria)
	{
		$query->join('shelves','materials.shelve_id','=','shelves.id')
			  ->where('shelves.branch_id','=',$branch_id)
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('title','LIKE',"%$search_criteria%")
			  			  ->orWhere('author','LIKE',"%$search_criteria%")
			  			  ->orWhere('auto_cod','LIKE',"%$search_criteria%")
			  			  ->orWhere('isbn','LIKE',"%$search_criteria%");
			  })
			  ->orderBy('title','asc');
		return $query;
	}
	
	public function scopeSearchMaterialsByBranchByFilter($query,$branch_id,$search_criteria,$search_filter)
	{
		$query->join('shelves','materials.shelve_id','=','shelves.id')
			  ->where('shelves.branch_id','=',$branch_id)
			  ->where('materials.thematic_area','=',$search_filter)
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('title','LIKE',"%$search_criteria%")
			  			  ->orWhere('author','LIKE',"%$search_criteria%")
			  			  ->orWhere('auto_cod','LIKE',"%$search_criteria%")
			  			  ->orWhere('isbn','LIKE',"%$search_criteria%");
			  })
			  ->orderBy('title','asc');
		return $query;
	}

	/* Catalog */
	public function scopeSearchMaterialsCatalog($query,$search_criteria)
	{
		$query->join('shelves','materials.shelve_id','=','shelves.id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('title','LIKE',"%$search_criteria%")
			  			  ->orWhere('author','LIKE',"%$search_criteria%")
			  			  ->orWhere('base_cod','LIKE',"%$search_criteria%")
			  			  ->orWhere('isbn','LIKE',"%$search_criteria%");
			  })
			  ->orderBy('title','asc')
			  ->groupBy('base_cod','branch_id','to_home')
			  ->select('materials.*','shelves.*',DB::raw('sum(case when available = 1 then 1 else 0 end) as total_materials'));
		return $query;
	}

	public function scopeSearchMaterialsCatalogByBranch($query,$search_criteria,$branch_id)
	{
		$query->join('shelves','materials.shelve_id','=','shelves.id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('title','LIKE',"%$search_criteria%")
			  			  ->orWhere('author','LIKE',"%$search_criteria%")
			  			  ->orWhere('base_cod','LIKE',"%$search_criteria%")
			  			  ->orWhere('isbn','LIKE',"%$search_criteria%");
			  })
			  ->where('shelves.branch_id','=',$branch_id)
			  ->orderBy('title','asc')
			  ->groupBy('base_cod','branch_id','to_home')
			  ->select('materials.*','shelves.*',DB::raw('sum(case when available = 1 then 1 else 0 end) as total_materials'));
		return $query;
	}

	public function scopeSearchMaterialsCatalogByThematic($query,$search_criteria,$thematic_area_id)
	{
		$query->join('shelves','materials.shelve_id','=','shelves.id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('title','LIKE',"%$search_criteria%")
			  			  ->orWhere('author','LIKE',"%$search_criteria%")
			  			  ->orWhere('base_cod','LIKE',"%$search_criteria%")
			  			  ->orWhere('isbn','LIKE',"%$search_criteria%");
			  })
			  ->where('thematic_area','=',$thematic_area_id)
			  ->orderBy('title','asc')
			  ->groupBy('base_cod','branch_id','to_home')
			  ->select('materials.*','shelves.*',DB::raw('sum(case when available = 1 then 1 else 0 end) as total_materials'));
		return $query;
	}

	public function scopeSearchMaterialsCatalogByBranchThematic($query,$search_criteria,$branch_id,$thematic_area_id)
	{
		$query->join('shelves','materials.shelve_id','=','shelves.id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('title','LIKE',"%$search_criteria%")
			  			  ->orWhere('author','LIKE',"%$search_criteria%")
			  			  ->orWhere('base_cod','LIKE',"%$search_criteria%")
			  			  ->orWhere('isbn','LIKE',"%$search_criteria%");
			  })
			  ->where('shelves.branch_id','=',$branch_id)
			  ->where('thematic_area','=',$thematic_area_id)
			  ->orderBy('title','asc')
			  ->groupBy('base_cod','branch_id','to_home')
			  ->select('materials.*','shelves.*',DB::raw('sum(case when available = 1 then 1 else 0 end) as total_materials'));
		return $query;
	}

	public function scopeGetMaterialForReservation($query,$material_code,$material_shelf)
	{
		$query->where('base_cod','=',$material_code)
			  ->where('shelve_id','=',$material_shelf)
			  ->orderBy('available','asc');
		return $query;
	}

	public function scopeSearchMaterialByCode($query,$material_code)
	{
		$query->where('base_cod','=',$material_code);
		return $query;
	}

	public function scopeGetAvailableMaterialByCodeBranch($query,$material_code,$branch_id)
	{
		$query->join('shelves','materials.shelve_id','=','shelves.id')
			  ->where('materials.base_cod','=',$material_code)
			  ->where('materials.available','=','1')
			  ->where('shelves.branch_id','=',$branch_id);
		return $query;
	}

	public function scopeGetLastBookEntriesByDate($query,$date_ini,$date_end)
	{
		$query->withTrashed()
			  ->join('shelves','materials.shelve_id','=','shelves.id')
			  ->join('branches','shelves.branch_id','=','branches.id')
			  ->join('thematic_areas','materials.thematic_area','=','thematic_areas.id')
			  ->where('material_type','=','1')
			  ->where('materials.created_at','>=',$date_ini)
			  ->where('materials.created_at','<=',$date_end)
			  ->orderBy('materials.created_at','asc')
			  ->groupBy('base_cod','branch_id')
			  ->select('materials.*','branches.name','thematic_areas.name as thematic_area_name',DB::raw('count(*) as total_entries'));
		return $query;
	}

	public function scopeGetLastBookEntriesByDateBranch($query,$date_ini,$date_end,$branch_id)
	{
		$query->withTrashed()
			  ->join('shelves','materials.shelve_id','=','shelves.id')
			  ->join('branches','shelves.branch_id','=','branches.id')
			  ->join('thematic_areas','materials.thematic_area','=','thematic_areas.id')
			  ->where('material_type','=','1')
			  ->where('materials.created_at','>=',$date_ini)
			  ->where('materials.created_at','<=',$date_end)
			  ->where('shelves.branch_id','=',$branch_id)
			  ->orderBy('created_at','asc')
			  ->groupBy('base_cod','branch_id')
			  ->select('materials.*','branches.name','thematic_areas.name as thematic_area_name',DB::raw('count(*) as total_entries'));
		return $query;
	}

	public function scopeGetLastBookEntriesByDateThematicArea($query,$date_ini,$date_end,$thematic_area_id)
	{
		$query->withTrashed()
			  ->join('shelves','materials.shelve_id','=','shelves.id')
			  ->join('branches','shelves.branch_id','=','branches.id')
			  ->join('thematic_areas','materials.thematic_area','=','thematic_areas.id')
			  ->where('material_type','=','1')
			  ->where('materials.created_at','>=',$date_ini)
			  ->where('materials.created_at','<=',$date_end)
			  ->where('thematic_area','=',$thematic_area_id)
			  ->orderBy('materials.created_at','asc')
			  ->groupBy('base_cod','branch_id')
			  ->select('materials.*','branches.name','thematic_areas.name as thematic_area_name',DB::raw('count(*) as total_entries'));
		return $query;
	}

	public function scopeGetLastBookEntriesByDateBranchThematicArea($query,$date_ini,$date_end,$branch_id,$thematic_area_id)
	{
		$query->withTrashed()
			  ->join('shelves','materials.shelve_id','=','shelves.id')
			  ->join('branches','shelves.branch_id','=','branches.id')
			  ->join('thematic_areas','materials.thematic_area','=','thematic_areas.id')
			  ->where('material_type','=','1')
			  ->where('materials.created_at','>=',$date_ini)
			  ->where('materials.created_at','<=',$date_end)
			  ->where('shelves.branch_id','=',$branch_id)
			  ->where('thematic_area','=',$thematic_area_id)
			  ->orderBy('materials.created_at','asc')
			  ->groupBy('base_cod','branch_id')
			  ->select('materials.*','branches.name','thematic_areas.name as thematic_area_name',DB::raw('count(*) as total_entries'));
		return $query;
	}

	public function scopeGetBranchLaborDaysByMaterial($query,$material_id)
	{
		$query->join('shelves','materials.shelve_id','=','shelves.id')
			  ->join('branches','shelves.branch_id','=','branches.id')
			  ->where('materials.mid','=',$material_id)
			  ->select('branches.day_ini','branches.day_end');
		return $query;
	}
}
