<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
	use HasFactory;
	protected $fillable = [
		'name',
		'rpg_class',
		'health',
		'weapon',
		'item',
		'armor',
		'coins'
	];
}
