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

	public function scopeGetTopLoansByDate($query,$date_ini,$date_end)
	{
		$query->withTrashed()
			  ->join('materials','loans.material_id','=','materials.mid')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->orderBy('loans_by_material','desc')
			  ->groupBy('materials.base_cod')
			  ->select('materials.base_cod','materials.title','materials.author','materials.editorial','loans.*',DB::raw('count(*) as loans_by_material'));
		return $query;
	}

	public function scopeGetTopLoansByDateBranch($query,$date_ini,$date_end,$branch_id)
	{
		$query->withTrashed()
			  ->join('materials','loans.material_id','=','materials.mid')
			  ->join('shelves','materials.shelve_id','=','shelves.id')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->where('shelves.branch_id','=',$branch_id)
			  ->orderBy('loans_by_material','desc')
			  ->groupBy('materials.base_cod')
			  ->select('materials.base_cod','materials.title','materials.author','materials.editorial','loans.*',DB::raw('count(*) as loans_by_material'));
		return $query;
	}

	public function scopeGetTopLoansByDateThematicArea($query,$date_ini,$date_end,$thematic_area_id)
	{
		$query->withTrashed()
			  ->join('materials','loans.material_id','=','materials.mid')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->where('materials.thematic_area','=',$thematic_area_id)
			  ->orderBy('loans_by_material','desc')
			  ->groupBy('materials.base_cod')
			  ->select('materials.base_cod','materials.title','materials.author','materials.editorial','loans.*',DB::raw('count(*) as loans_by_material'));
		return $query;
	}

	public function scopeGetTopLoansByDateBranchThematicArea($query,$date_ini,$date_end,$branch_id,$thematic_area_id)
	{
		$query->withTrashed()
			  ->join('materials','loans.material_id','=','materials.mid')
			  ->join('shelves','materials.shelve_id','=','shelves.id')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->where('shelves.branch_id','=',$branch_id)
			  ->where('materials.thematic_area','=',$thematic_area_id)
			  ->orderBy('loans_by_material','desc')
			  ->groupBy('materials.base_cod')
			  ->select('materials.base_cod','materials.title','materials.author','materials.editorial','loans.*',DB::raw('count(*) as loans_by_material'));
		return $query;
	}

	public function scopeGetLoansByUserDate($query,$user_id,$date_ini,$date_end)
	{
		$query->withTrashed()
			  ->join('materials','loans.material_id','=','materials.mid')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->where('user_id','=',$user_id)
			  ->orderBy('loans_by_material','desc')
			  ->groupBy('materials.base_cod')
			  ->select('materials.base_cod','materials.title','materials.author','materials.editorial','loans.*',DB::raw('count(*) as loans_by_material'));
		return $query;
	}

	public function scopeGetLoansByUserDateDetailed($query,$user_id,$date_ini,$date_end)
	{
		$query->withTrashed()
			  ->join('materials','loans.material_id','=','materials.mid')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->where('user_id','=',$user_id)
			  ->orderBy('created_at','desc')
			  ->select('materials.base_cod','materials.auto_cod','materials.title','materials.author','materials.editorial','loans.*');
		return $query;
	}

	public function scopeGetLoansByMaterialDate($query,$material_code,$date_ini,$date_end)
	{
		$query->withTrashed()
			  ->join('materials','loans.material_id','=','materials.mid')
			  ->join('users','loans.user_id','=','users.id')
			  ->join('persons','users.person_id','=','persons.id')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->where('materials.base_cod','=',$material_code)
			  ->orderBy('loans_by_user','desc')
			  ->groupBy('users.id')
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.mail','loans.*',DB::raw('count(*) as loans_by_user'));
		return $query;
	}

	public function scopeGetLoansByMaterialDateDetailed($query,$material_code,$date_ini,$date_end)
	{
		$query->withTrashed()
			  ->join('materials','loans.material_id','=','materials.mid')
			  ->join('users','loans.user_id','=','users.id')
			  ->join('persons','users.person_id','=','persons.id')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->where('materials.base_cod','=',$material_code)
			  ->orderBy('created_at','desc')
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.mail','loans.*');
		return $query;
	}

	public function scopeGetLoansByTeacherDate($query,$date_ini,$date_end)
	{
		$query->withTrashed()

			  ->join('materials','loans.material_id','=','materials.mid')

			  ->join('users','loans.user_id','=','users.id')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->where('users.profile_id','=','2')
			  ->orderBy('loans_by_material','desc')
			  ->groupBy('materials.base_cod')
			  ->select('materials.base_cod','materials.title','materials.author','materials.editorial','loans.*',DB::raw('count(*) as loans_by_material'));
		return $query;
	}

	public function scopeGetLoansByTeacherDateDetailed($query,$date_ini,$date_end)
	{
		$query->withTrashed()
			  ->join('materials','loans.material_id','=','materials.mid')
			  ->join('users','loans.user_id','=','users.id')
			  ->where('loans.created_at','>=',$date_ini)
			  ->where('loans.created_at','<=',$date_end)
			  ->where('users.profile_id','=','2')
			  ->orderBy('created_at','desc')
			  ->select('materials.base_cod','materials.auto_cod','materials.title','materials.author','materials.editorial','loans.*');
		return $query;
	}

}
