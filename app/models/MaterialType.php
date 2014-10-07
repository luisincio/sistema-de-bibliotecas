<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class MaterialType extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;
}