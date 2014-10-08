<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class MaterialTypexprofile extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;
}