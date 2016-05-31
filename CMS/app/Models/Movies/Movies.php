<?php

namespace App\Models\Movies;

use Illuminate\Database\Eloquent\Model;

class Movies extends Model 
{
	protected 	$guarded = [];
	protected 	$table = 'movies';
	public 		$timestamps = false;
	
}