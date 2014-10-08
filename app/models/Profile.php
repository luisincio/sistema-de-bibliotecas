<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Profile extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;
}