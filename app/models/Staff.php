<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Staff extends Eloquent{
	use SoftDeletingTrait;

	protected $table = 'staff';
	protected $softDelete = true;

}
