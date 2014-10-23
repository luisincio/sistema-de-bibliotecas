<?php


class DetailsPurchaseOrder extends Eloquent{

	public $timestamps = false;


	public function scopeGetDetailsByPurchaseOrder($query,$id)
	{
		$query->where('purchase_order_id','=',$id);
		return $query;
	}


}	