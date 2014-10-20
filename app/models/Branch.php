<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Branch extends Eloquent{
	
	use SoftDeletingTrait;
	protected $table = 'branches';
	protected $softDelete = true;
}