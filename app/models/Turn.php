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

}
