<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Staff extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'staff';
	
	public function scopeSearchStaffByPerson($query,$person_id)
	{
		$query->withTrashed()
			  ->where('person_id','=',$person_id);
		return $query;
	}

	public function scopeGetStaffsInfo($query)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','staff.person_id')
			  ->join('turns','turns.id','=','staff.turn_id')
			  ->join('branches','branches.id','=','turns.branch_id')
			  ->where('role_id','<>',1)
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*','turns.hour_ini','turns.hour_end','branches.name as branch_name');
		return $query;
	}

	public function scopeSearchStaffs($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','staff.person_id')
			  ->join('turns','turns.id','=','staff.turn_id')
			  ->join('branches','branches.id','=','turns.branch_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			   ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*','turns.hour_ini','turns.hour_end','branches.name as branch_name')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchActiveStaffs($query,$search_criteria)
	{
		$query->join('persons','persons.id','=','staff.person_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			   ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchDeletedStaffs($query,$search_criteria)
	{
		$query->onlyTrashed()
			  ->join('persons','persons.id','=','staff.person_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchStaffById($query,$search_criteria)
	{
		$query->join('persons','persons.id','=','staff.person_id')
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
			  ->where('staff.id','=',$search_criteria);
		return $query;
	}

	public function scopeGetStaffInfoByTurns($query,$turns_array)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','staff.person_id')
			  ->whereIn('staff.turn_id',$turns_array)
			  ->where('role_id','<>',1)
			  ->select('staff.*','persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality');
		return $query;
	}



	public function scopeSearchStaffsByTurns($query,$search_criteria,$turns_array)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','staff.person_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			  ->whereIn('staff.turn_id',$turns_array)
			  ->where('staff.role_id','<>',1)
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchActiveStaffsByTurns($query,$search_criteria,$turns_array)
	{
		$query->join('persons','persons.id','=','staff.person_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			  ->whereIn('staff.turn_id',$turns_array)
			  ->where('staff.role_id','<>',1)
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchDeletedStaffsByTurns($query,$search_criteria,$turns_array)
	{
		$query->onlyTrashed()
			  ->join('persons','persons.id','=','staff.person_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			  ->whereIn('staff.turn_id',$turns_array)
			  ->where('staff.role_id','<>',1)
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}
}
