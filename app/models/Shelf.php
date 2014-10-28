<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Shelf extends Eloquent{
	use SoftDeletingTrait;

	protected $table = 'shelves';
	protected $softDelete = true;

	public function scopeGetShelvesByBranch($query,$branch_id)
	{
		$query->where('branch_id','=',$branch_id);
		return $query;
	}

	public function scopeGetShelfByCodeDifferentId($query,$id,$code)
	{
		$query->where('id','<>',$id)
			  ->where('code','=',$code);
		return $query;
	}

	public function scopeGetShelfByCode($query,$code)
	{
		$query->where('code','=',$code);
		return $query;
	}

}
