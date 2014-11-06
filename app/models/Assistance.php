<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Assistance extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeGetTodayStaffAssistance($query,$staff_id,$today)
	{
		$query->where('staff_id','=',$staff_id)
			  ->where('date','=',$today);
		return $query;
	}

	public function scopeGetStaffAssistance($query,$staff_id)
	{
		$query->where('staff_id','=',$staff_id)
			  ->orderBy('date','desc');
		return $query;
	}
}