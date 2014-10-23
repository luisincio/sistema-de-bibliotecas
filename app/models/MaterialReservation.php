<?php


use Illuminate\Database\Eloquent\SoftDeletingTrait;

class MaterialReservation extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeGetUserReservations($query,$user_id)
	{
		$query->join('materials','materials.mid','=','material_reservations.material_id')
			  ->where('user_id','=',$user_id);
		return $query;
	}

	public function scopeGetReservationByMaterial($query,$material_id)
	{
		$query->where('material_id','=',$material_id);
		return $query;
	}
}
