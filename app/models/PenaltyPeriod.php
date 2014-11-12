<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PenaltyPeriod extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeGetPenaltyPeriodByDate($query,$date)
	{
		$query->where('date_ini','<=',$date)
			  ->where('date_end','>=',$date);
		return $query;
	}
}