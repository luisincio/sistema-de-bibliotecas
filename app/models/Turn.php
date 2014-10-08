<?php


use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Turn extends Eloquent{
	use SoftDeletingTrait;
	protected $softDelete = true;

}
