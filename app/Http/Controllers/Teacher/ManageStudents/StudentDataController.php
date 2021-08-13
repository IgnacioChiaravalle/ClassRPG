<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralFunctions\HealthValuesController;
use App\Http\Controllers\User\UserManagementController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Teacher_Student;
use Illuminate\Http\Request;

class StudentDataController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	public function getOrFail_TeacherStudentRelation($studentName) {
		return Teacher_Student::where([
			['student_name', '=', $studentName],
			['teacher_name', '=', Auth::user()->name]
		])->firstOrFail();
	}
	private function getOtherTeachers($currentTeacherName, $studentName) {
		return Teacher_Student::where([
			['student_name', '=', $studentName],
			['teacher_name', '!=', $currentTeacherName]
		])->get();
	}

	protected function captureStudentData($studentName) {
		$teacherStudentRelation = $this->getOrFail_TeacherStudentRelation($studentName);
		$studentCharacter = $this->getStudentCharacter($studentName);
		$maxStudentHealth = $this->getMaxStudentHealth($studentCharacter);
		return View::make('teacher.manage_students.handle_student_data')->with('teacher', $this->getTeacher())
																		->with('studentUser', $this->getStudentUser($studentName))
																		->with('studentCharacter', $studentCharacter)
																		->with('maxStudentHealth', $maxStudentHealth)
																		->with('studentNotes', $teacherStudentRelation->notes_on_student);
	}

	private function getTeacher() {
		return Teacher::where('name', Auth::user()->name)->first();
	}
	private function getStudentCharacter($studentName) {
		return Student::where('name', $studentName)->first();
	}
	private function getMaxStudentHealth($studentCharacter) {
		return (new HealthValuesController)->getMaxStudentHealth($studentCharacter);
	}
	private function getStudentUser($studentName) {
		return (new UserManagementController)->getUserByName($studentName);
	}

	protected function editStudentData(Request $request, $studentName) {
		$this->validateStudentDataRequest($request);
		$studentCharacter = $this->getStudentCharacter($studentName);
		$finalCoins = $studentCharacter->coins + $request->coins;
		$finalHealth = $studentCharacter->health + $request->health;
		$studentCharacter->update([
			'coins' => $finalCoins >= 0 ? $finalCoins : 0,
			'health' => $this->adjustHealth($studentCharacter, $finalHealth)
		]);
		$this->getOrFail_TeacherStudentRelation($studentName)->update([
			'notes_on_student' => $request->notes_on_student
		]);
		return redirect()->route('/');
	}

	private function validateStudentDataRequest (Request $request) {
		$request->validate([
			'health' => ['numeric', 'integer'],
			'coins' => ['numeric', 'integer'],
			'notes_on_student' => ['nullable', 'max:65,535']
		]);
	}

	private function adjustHealth($studentCharacter, $finalHealth) {
		$maxStudentHealth = $this->getMaxStudentHealth($studentCharacter);
		if ($finalHealth > $maxStudentHealth)
			$finalHealth = $maxStudentHealth;
		elseif ($finalHealth < 0)
			$finalHealth = 0;
		return $finalHealth;
	}
}
