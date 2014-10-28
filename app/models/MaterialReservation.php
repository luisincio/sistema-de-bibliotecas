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

	public function scopeGetReservationByUserMaterialCode($query,$user_id,$material_code)
	{
		$query->join('materials','materials.mid','=','material_reservations.material_id')
			  ->where('user_id','=',$user_id)
			  ->where('base_cod','=',$material_code);
		return $query;
	}	

	public function scopeGetUserReservationsForLoans($query,$user_id)
	{
		$query->join('materials','materials.mid','=','material_reservations.material_id')
			  ->where('user_id','=',$user_id)
			  ->select('materials.auto_cod','materials.title','materials.author','materials.editorial','material_reservations.*');
		return $query;
	}
}
