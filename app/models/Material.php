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
}
