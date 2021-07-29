<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Teacher_Student;
use Illuminate\Http\Request;

class StudentDataController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	protected function captureStudentData($studentName) {
		return View::make('teacher.manage_students.handle_data')->with('teacher', $this->getTeacher())
																->with('studentUser', $this->getStudentUser($studentName))
																->with('studentCharacter', $this->getStudentCharacter($studentName))
																->with('studentNotes', $this->getTeacherStudentRelation($studentName)->notes_on_student);
	}
		private function getTeacher() {
			return Teacher::where('name', Auth::user()->name)->first();
		}
		private function getStudentUser($studentName) {
			return User::where('name', $studentName)->first();
		}
		private function getStudentCharacter($studentName) {
			return Student::where('name', $studentName)->first();
		}
		private function getTeacherStudentRelation($studentName) {
			return Teacher_Student::where('student_name', $studentName)->first();
		}

	protected function editStudentData(Request $request, $studentName) {
		$this->validateRequest($request);
		$studentCharacter = $this->getStudentCharacter($studentName);	
		$studentCharacter->update([
			'coins' => $studentCharacter->coins + $request->coins,
			'health' => $studentCharacter->health + $request->health //VALIDATE NOT LOWER THAN 0, NOT GREATER THAN MAX HEALTH.
		]);
		$this->getTeacherStudentRelation($studentName)->update([
			'notes_on_student' => $request->notes_on_student
		]);
		return redirect()->route('/');
	}

	private function validateRequest (Request $request) {
		$request->validate([
			'health' => ['numeric', 'integer'],
			'coins' => ['numeric', 'integer'],
			'notes_on_student' => ['nullable']
		]);
	}

	protected function editStudentUserEmail(Request $request, $studentName) {
		$studentUser = $this->getStudentUser($studentName);
		if ($request->email != $studentUser->email) {
			$request->validate(['email' => ['email', 'unique:users']]);
			$studentUser->update(['email' => $request->email]);
		}
		return redirect()->route('/');
	}
}
