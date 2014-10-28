<?php


use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Loan extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeSearchUserLoans($query,$user_id)
	{
		$query->join('materials','materials.mid','=','loans.material_id')
			  ->where('loans.user_id','=',$user_id);
		return $query;
	}

	public function scopeSearchUserLoansByMaterial($query,$user_id,$materia_code)
	{
		$query->join('materials','materials.mid','=','loans.material_id')
			  ->where('loans.user_id','=',$user_id)
			  ->where('materials.base_cod','=',$materia_code);
		return $query;
	}

}
