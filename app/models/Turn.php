<?php


use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Turn extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeGetTurnsByBranch($query,$branch_id)
	{	
		$query->where('branch_id','=',$branch_id);
		return $query;
	}

	public function scopeGetTurnsByNameBranch($query,$turn_name,$branch_id)
	{	
		$query->where('name','=',$turn_name)
			  ->where('branch_id','=',$branch_id);
		return $query;
	}

}
