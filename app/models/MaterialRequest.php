<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class MaterialRequest extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeGetMaterialsRequest($query)
	{		
		return $query;
	}

	public function scopesearchMaterialsRequest($query,$search_criteria,$date_ini,$date_end)
	{
		if($date_ini && $date_end){
			$query->where('material_requests.date','>=',$date_ini)
			  	->where('material_requests.date','<=',$date_end)
			  	->whereNested(function($query) use($search_criteria){
			  		$query->where('title','LIKE',"%$search_criteria%")
			  			  ->orWhere('author','LIKE',"%$search_criteria%")
			  			  ->orWhere('editorial','LIKE',"%$search_criteria%");
			  })
			  ->orderBy('date','asc');
		}else{
			$query->whereNested(function($query) use($search_criteria){
				  		$query->where('title','LIKE',"%$search_criteria%")
				  			  ->orWhere('author','LIKE',"%$search_criteria%")
				  			  ->orWhere('editorial','LIKE',"%$search_criteria%");
				  })
				  ->orderBy('title','asc');
		}
		return $query;
	}
	
	public function scopeSearchMaterialsRequestByFilter($query,$search_criteria,$search_filter,$date_ini,$date_end)
	{
		if($date_ini && $date_end){
			$query->where('material_requests.date','>=',$date_ini)
			  	  ->where('material_requests.date','<=',$date_end)
			  	  ->where('material_requests.material_request_type_id','=',$search_filter)
			  	  ->whereNested(function($query) use($search_criteria){
			  			$query->where('title','LIKE',"%$search_criteria%")
			  			->orWhere('author','LIKE',"%$search_criteria%")
			  			->orWhere('editorial','LIKE',"%$search_criteria%");
			  		})
			  		->orderBy('date','asc');
		}else{
			$query->where('material_requests.material_request_type_id','=',$search_filter)
			  	  ->whereNested(function($query) use($search_criteria){
			  			$query->where('title','LIKE',"%$search_criteria%")
			  			->orWhere('author','LIKE',"%$search_criteria%")
			  			->orWhere('editorial','LIKE',"%$search_criteria%");
			  		})
			  		->orderBy('title','asc');	
		}		
		return $query;
	}

	public function scopeGetMostRequestedMaterialsByDate($query,$date_ini,$date_end)
	{
		$query->withTrashed()
			  ->join('material_request_types','material_requests.material_request_type_id','=','material_request_types.id')
			  ->where('date','>=',$date_ini)
			  ->where('date','<=',$date_end)
			  ->orderBy('date','desc')
			  ->groupBy('title')
			  ->select('material_requests.*','material_request_types.name',DB::raw('count(*) as total_requests'));
		return $query;
	}
	
}
