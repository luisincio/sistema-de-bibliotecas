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

}
