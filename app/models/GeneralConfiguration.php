<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GeneralConfiguration extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;
}