<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PenaltyPeriod extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;
}