<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
	use HasFactory;
	protected $fillable = [
		'name',
		'teacher_student_relation_id',
		'description',
		'damage_caused',
		'damage_period',
		'max_health',
		'current_health',
		'start_date',
		'finish_date',
		'coins_reward',
		'other_rewards',
		'archived'
	];
}
