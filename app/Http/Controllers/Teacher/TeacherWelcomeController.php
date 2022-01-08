<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ListSort\ListSortController;
use App\Http\Controllers\HealthValues\HealthValuesController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher_Student;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;

class TeacherWelcomeController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	public function getTeacherWelcome(Teacher $teacher) {
		$teacher_students = Teacher_Student::where('teacher_name', $teacher->name)->get();
		$my_students = array();
		$hVC = new HealthValuesController;
		foreach($teacher_students as $ts) {
			array_push($my_students, User::where('name', $ts->student_name)->first());
			$this->addHealthAndCoins($hVC, end($my_students));
		}
		if (!empty($my_students)) {
			$my_students = (new ListSortController)->quicksort($my_students, 'user');
			return View::make('teacher.teacher_welcome')->with('teacher', $teacher)->with('my_students', $my_students);
		}
		else
			return View::make('teacher.teacher_welcome')->with('teacher', $teacher);
	}
		private function addHealthAndCoins($hVC, $user) {
			$student = Student::where('name', $user->name)->first();
			$user->current_health = $student->health;
			$user->max_health = $hVC->getMaxStudentHealth($student);
			$user->coins = $student->coins;
		}
}
