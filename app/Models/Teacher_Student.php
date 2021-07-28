<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher_Student extends Model
{
	use HasFactory;
	protected $fillable = [
		'teacher_name',
		'student_name'
	];

	protected $table = 'teacher_students';
}
