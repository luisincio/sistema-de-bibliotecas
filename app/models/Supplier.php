<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Supplier extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeSearchSuppliersDoners($query,$search_criteria)
	{
		$query->where('name','LIKE',"%$search_criteria%")
			  ->orWhere('ruc','LIKE',"%$search_criteria%")
			  ->orWhere('sales_representative','LIKE',"%$search_criteria%")
			  ->orderBy('name','asc');
		return $query;
	}

	public function scopeSearchSuppliers($query,$search_criteria)
	{
		$query->whereNull('flag_doner')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('name','LIKE',"%$search_criteria%")
			  			  ->orWhere('ruc','LIKE',"%$search_criteria%")
			  			  ->orWhere('sales_representative','LIKE',"%$search_criteria%");
			  })
			  ->orderBy('name','asc');
		return $query;
	}

	public function scopeSearchDoners($query,$search_criteria)
	{
		$query->whereNotNull('flag_doner')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('name','LIKE',"%$search_criteria%")
			  			  ->orWhere('ruc','LIKE',"%$search_criteria%")
			  			  ->orWhere('sales_representative','LIKE',"%$search_criteria%");
			  })
			  ->orderBy('name','asc');
		return $query;
	}

	public function scopeGetDoners($query)
	{
		$query->whereNotNull('flag_doner')
			  ->orderBy('name','asc');
		return $query;
	}
}
