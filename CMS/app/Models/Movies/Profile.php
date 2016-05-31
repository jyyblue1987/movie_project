<?php

namespace App\Models\Movies;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model 
{
	protected 	$guarded = ['username','password'];
	protected 	$table = 'users';
	public 		$timestamps = false;
	
}