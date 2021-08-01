<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ArrayHandlerController;
use App\Http\Controllers\HealthValuesController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher_Student;
use App\Models\Student;
use App\Models\User;

class TeacherWelcomeController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	public function getTeacherWelcome($teacher) {
		$teacher_students = Teacher_Student::where('teacher_name', $teacher->name)->get();
		$my_students = array();
		foreach($teacher_students as $ts)
			array_push($my_students, User::where('name', $ts->student_name)->first());
		
		$aHC = new ArrayHandlerController;
		if ($aHC->findSize($my_students) > 0) {
			$my_students = $aHC->quicksort($my_students, 'user');
			$this->addHealthAndCoins($my_students, $aHC);
			return View::make('teacher.teacher_welcome')->with('teacher', $teacher)->with('my_students', $my_students);
		}
		else
			return View::make('teacher.teacher_welcome')->with('teacher', $teacher);
	}
		private function addHealthAndCoins($users, $aHC) {
			foreach ($users as $user) {
				$student = Student::where('name', $user->name)->first();
				$user->current_health = $student->health;
				$user->max_health = (new HealthValuesController)->getMaxStudentHealth($student);
				$user->coins = $student->coins;
			}

		}
}
