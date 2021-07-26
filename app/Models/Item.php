<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	use HasFactory;
	protected $fillable = [
		'name',
		'rpg_class',
		'added_health',
		'added_damage',
		'cost'
	];
}
