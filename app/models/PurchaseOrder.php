<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PurchaseOrder extends Eloquent{
	
	use SoftDeletingTrait;	
	protected $softDelete = true;

	public function scopeGetPurchaseOrderInfo($query)
	{
		$query->join('suppliers','suppliers.id','=','purchase_orders.supplier_id')
			  ->select('suppliers.name','suppliers.ruc','suppliers.phone','suppliers.email','purchase_orders.*');
		return $query;
	}
	
	public function scopeSearchPurchaseOrderByDate($query,$fecha_emision, $fecha_vencimiento)
	{
		$query->join('suppliers','suppliers.id','=','purchase_orders.supplier_id')
			  ->where('date_issue','>=',$fecha_emision)
			  ->where('date_issue','<=', $fecha_vencimiento)
			  ->select('suppliers.name','suppliers.ruc','suppliers.phone','suppliers.email','purchase_orders.*');		  			  			  				  	  			  		  			 
		return $query;
	}
	
}