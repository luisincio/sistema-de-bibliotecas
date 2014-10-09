<?php


use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeSearchUserByPerson($query,$person_id)
	{
		$query->where('person_id','=',$person_id);
		return $query;
	}
}
