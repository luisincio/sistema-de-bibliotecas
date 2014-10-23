<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PurchaseOrder extends Eloquent{
	
	use SoftDeletingTrait;	
	protected $softDelete = true;
	
	public function scopeSearchPurchaseOrderByDate($query,$fecha_emision, $fecha_vencimiento){
		
		$query->where('date_issue','>=',$fecha_emision)
			  ->where('date_issue','<=', $fecha_vencimiento);			  			  			  				  	  			  		  			 
		return $query;
	}
	
}