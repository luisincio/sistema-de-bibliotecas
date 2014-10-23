<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CubicleType extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;
}