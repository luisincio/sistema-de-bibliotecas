<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PhysicalElement extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeGetPhysicalElementsByBranch($query,$branch_id)
	{
		$query->where('branch_id','=',$branch_id);
		return $query;
	}

	public function scopeGetPhysicalElementByNameDifferentId($query,$id,$name,$branch_id)
	{
		$query->where('id','<>',$id)
			  ->where('name','=',$name)
			  ->where('branch_id','=',$branch_id);
		return $query;
	}

	public function scopeGetPhysicalElementByName($query,$name,$branch_id)
	{
		$query->where('name','=',$name)
			  ->where('branch_id','=',$branch_id);
		return $query;
	}
}