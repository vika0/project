<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Object extends Model
{
    protected $fillable = [
    	'name', 'price', 'address'
	];
}
