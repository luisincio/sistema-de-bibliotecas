<?php


use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Material extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;
}
