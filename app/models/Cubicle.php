<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Cubicle extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeGetCubicleByBranchType($query,$branch_id,$cubicle_type_id)
	{
		$query->where('branch_id','=',$branch_id)
			  ->where('cubicle_type_id','=',$cubicle_type_id);
		return $query;
	}

	public function scopeGetCubicleByBranch($query,$branch_id)
	{
		$query->where('branch_id','=',$branch_id);
		return $query;
	}

	public function scopeGetCubicleByCodeDifferentId($query,$id,$code)
	{
		$query->where('id','<>',$id)
			  ->where('code','=',$code);
		return $query;
	}

	public function scopeGetCubicleByCode($query,$code)
	{
		$query->where('code','=',$code);
		return $query;
	}
}