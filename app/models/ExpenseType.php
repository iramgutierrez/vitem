<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ExpenseType extends \Eloquent {

	use SoftDeletingTrait;

	protected $fillable = [];

}