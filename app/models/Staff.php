<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Staff extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $table = 'staff';
	
	public function scopeSearchStaffByPerson($query,$person_id)
	{
		$query->where('person_id','=',$person_id);
		return $query;
	}

	public function scopeGetStaffsInfo($query)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','staff.person_id')
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*');
		return $query;
	}

	public function scopeSearchStaffs($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','staff.person_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			   ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
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
			   ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
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
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchStaffById($query,$search_criteria)
	{
		$query->join('persons','persons.id','=','staff.person_id')
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','staff.*')
			  ->where('staff.id','=',$search_criteria);
		return $query;
	}

}
