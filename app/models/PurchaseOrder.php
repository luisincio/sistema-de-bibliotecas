<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PurchaseOrder extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;
}