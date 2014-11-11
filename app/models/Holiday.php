<?php


class Holiday extends Eloquent{

	public $timestamps = false;

	public function scopeSearchHoliday($query,$date)
	{
		$query->where('date','=',$date);
		return $query;
	}

}