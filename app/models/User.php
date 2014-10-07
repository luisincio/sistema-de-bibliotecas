<?php


use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;
}
