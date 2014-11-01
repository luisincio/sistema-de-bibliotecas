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

	public function scopeGetApprovedPurchaseOrdersByDate($query,$date_ini,$date_end)
	{
		$query->join('suppliers','purchase_orders.supplier_id','=','suppliers.id')
			  ->where('state','=','1')
			  ->where('date_issue','>=',$date_ini)
			  ->where('date_issue','<=',$date_end)
			  ->select('purchase_orders.*','suppliers.name');
		return $query;
	}

	public function scopeGetRejectedPurchaseOrdersByDate($query,$date_ini,$date_end)
	{
		$query->onlyTrashed()
			  ->join('suppliers','purchase_orders.supplier_id','=','suppliers.id')
			  ->where('date_issue','>=',$date_ini)
			  ->where('date_issue','<=',$date_end)
			  ->select('purchase_orders.*','suppliers.name');
		return $query;
	}
	
}