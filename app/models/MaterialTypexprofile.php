<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class MaterialTypexprofile extends Eloquent{
	
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeGetMaterialTypesXProfile($query,$profile_id)
	{
		$query->where('profile_id','=',$profile_id);
		return $query;
	}

	public function scopeGetRowByProfileIdMaterialTypeId($query,$profile_id,$material_type_id)
	{
		$query->where('profile_id','=',$profile_id)
			  ->where('material_type_id','=',$material_type_id);
		return $query;
	}
}