<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;

	public function scopeSearchUserByPerson($query,$person_id)
	{
		$query->withTrashed()
			  ->where('person_id','=',$person_id);
		return $query;
	}

	public function scopeGetUsersInfo($query)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','users.person_id')
			  ->join('profiles','profiles.id','=','users.profile_id')
			  ->select('profiles.name as profile_name','persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*');
		return $query;
	}

	public function scopeSearchUsers($query,$search_criteria)
	{
		$query->withTrashed()
			  ->join('persons','persons.id','=','users.person_id')
			  ->join('profiles','profiles.id','=','users.profile_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			  ->select('profiles.name as profile_name','persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchActiveUsers($query,$search_criteria)
	{
		$query->join('persons','persons.id','=','users.person_id')
			  ->join('profiles','profiles.id','=','users.profile_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			  ->select('profiles.name as profile_name','persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchDeletedUsers($query,$search_criteria)
	{
		$query->onlyTrashed()
			  ->join('persons','persons.id','=','users.person_id')
			  ->join('profiles','profiles.id','=','users.profile_id')
			  ->whereNested(function($query) use($search_criteria){
			  		$query->where('persons.name','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.lastname','LIKE',"%$search_criteria%")
			  			  ->orWhere('persons.doc_number','LIKE',"%$search_criteria%");
			  })
			  ->select('profiles.name as profile_name','persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*')
			  ->orderBy('persons.name','asc');
		return $query;
	}

	public function scopeSearchUserById($query,$search_criteria)
	{
		$query->join('persons','persons.id','=','users.person_id')
			  ->select('persons.doc_number','persons.name','persons.lastname','persons.birth_date','persons.email','persons.address','persons.gender','persons.phone','persons.document_type','persons.nacionality','users.*')
			  ->where('users.id','=',$search_criteria);
		return $query;
	}

	public function scopeSearchUserByPersonId($query,$person_id)
	{
		$query->where('person_id','=',$person_id);
		return $query;
	}

	public function scopeSearchUserByDocument($query,$document)
	{
		$query->join('persons','persons.id','=','users.person_id')
			  ->join('profiles','profiles.id','=','users.profile_id')
			  ->where('doc_number','=',$document)
			  ->select('persons.name','persons.lastname','persons.email','users.*','profiles.name as profile_name');
		return $query;
	}

	public function scopeGetRestrictedUsers($query)
	{
		$query->join('persons','users.person_id','=','persons.id')
			  ->whereNotNull('restricted_until');
		return $query;
	}
}
