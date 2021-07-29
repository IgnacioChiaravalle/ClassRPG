<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Teacher_Student;
use Illuminate\Http\Request; //Check if needed.

class StudentDataController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	public function captureStudentData($studentName) {
		return View::make('teacher.manage_students.handle_data')->with('teacher', $this->getTeacher())
																->with('student_user', $this->getStudentUser())
																->with('student_character', $this->getStudentCharacter())
																->with('student_notes', $this->getStudentNotes());
	}
		private function getTeacher() {
			return Teacher::where('name', Auth::user()->name)->first();
		}
		private function getStudentUser() {
			return User::where('name', $studentName)->first();
		}
		private function getStudentCharacter() {
			return Student::where('name', $studentName)->first();
		}
		private function getStudentNotes() {
			return Teacher_Student::where('student_name', $studentName)->first()->notes_on_student;
		}
}
