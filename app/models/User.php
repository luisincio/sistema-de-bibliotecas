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

	public function scopeGetUsersInfo($query)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','users.person_id')
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*');
		return $query;
	}

	public function scopeSearchUsers($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','users.person_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			   ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchActiveUsers($query,$search_criteria)
	{
		$query->join('persons','persons.id','=','users.person_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			   ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchDeletedUsers($query,$search_criteria)
	{
		$query->onlyTrashed()
			  ->join('persons','persons.id','=','users.person_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchUserById($query,$search_criteria)
	{
		$query->join('persons','persons.id','=','users.person_id')
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.mail','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*')
			  ->where('users.id','=',$search_criteria);
		return $query;
	}
}
