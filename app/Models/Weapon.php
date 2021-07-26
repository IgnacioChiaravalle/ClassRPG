<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
	use HasFactory;
	protected $fillable = [
		'name',
		'rpg_class',
		'added_damage',
		'cost'
	];
}
