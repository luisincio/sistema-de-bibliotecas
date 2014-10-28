<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DevolutionPeriod extends Eloquent{
	
	use SoftDeletingTrait;	
	protected $softDelete = true;

	public function scopeGetDevolutionPeriodByDate($query,$date)
	{
		$query->where('date_ini','<=',$date)
			  ->where('date_end','>=',$date);
		return $query;
	}
	
}