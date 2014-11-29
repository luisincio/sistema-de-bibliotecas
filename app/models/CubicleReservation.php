<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CubicleReservation extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeGetReservationsByCubiclesDate($query,$cubicles,$date)
	{
		$query->where('reserved_at','=',$date)
			  ->whereIn('cubicle_id',$cubicles);
		return $query;
	}

	public function scopeGetReservationByUserDate($query,$user_id,$date)
	{
		$query->where('user_id','=',$user_id)
			  ->where('reserved_at','=',$date);
		return $query;
	}

	public function scopeGetReservationCubicleByUserDate($query,$user_id,$date)
	{
		$query->join('cubicles','cubicle_reservations.cubicle_id','=','cubicles.id')
			  ->join('branches','branches.id','=','cubicles.branch_id')
			  ->where('user_id','=',$user_id)
			  ->where('reserved_at','=',$date)
			  ->select('branches.name','cubicles.code','cubicles.capacity','cubicles.branch_id','cubicles.cubicle_type_id','cubicle_reservations.*');
		return $query;
	}

	public function scopeGetReservationCubicleByUserDateBranch($query,$user_id,$date,$branch_id)
	{
		$query->join('cubicles','cubicle_reservations.cubicle_id','=','cubicles.id')
			  ->where('user_id','=',$user_id)
			  ->where('reserved_at','=',$date)
			  ->where('branch_id','=',$branch_id)
			  ->select('cubicles.code','cubicles.capacity','cubicles.branch_id','cubicles.cubicle_type_id','cubicle_reservations.*');
		return $query;
	}
}