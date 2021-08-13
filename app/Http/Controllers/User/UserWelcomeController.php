<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\TeacherWelcomeController;
use App\Http\Controllers\Student\StudentWelcomeController;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserWelcomeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	protected function getUserWelcome() {
		$user = Auth::user();
		$userType = $user->type;
		try {
			if ($userType == 'teacher') {
				$teacher = Teacher::where('name', $user->name)->firstOrFail();
				return (new TeacherWelcomeController)->getTeacherWelcome($teacher);
			}
			if ($userType == 'student') {
				$student = Student::where('name', $user->name)->firstOrFail();
				return (new StudentWelcomeController)->getStudentWelcome($student);
			}
		}
		catch (ModelNotFoundException $ex) {
			return back()->with('message', "No hay ningún docente ni estudiante registrado para este usuario.");
		}
	}
}
