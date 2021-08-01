<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralFunctions\HealthValuesController;
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
		$studentCharacter = $this->getStudentCharacter($studentName);
		$maxStudentHealth = $this->getMaxStudentHealth($studentCharacter);
		return View::make('teacher.manage_students.handle_data')->with('teacher', $this->getTeacher())
																->with('studentUser', $this->getStudentUser($studentName))
																->with('studentCharacter', $studentCharacter)
																->with('maxStudentHealth', $maxStudentHealth)
																->with('studentNotes', $this->getTeacherStudentRelation($studentName)->notes_on_student);
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
		return User::where('name', $studentName)->first();
	}
	private function getTeacherStudentRelation($studentName) {
		return Teacher_Student::where('student_name', $studentName)->first();
	}

	protected function editStudentData(Request $request, $studentName) {
		$this->validateRequest($request);
		$studentCharacter = $this->getStudentCharacter($studentName);
		$finalCoins = $studentCharacter->coins + $request->coins;
		$finalHealth = $studentCharacter->health + $request->health;
		$studentCharacter->update([
			'coins' => $finalCoins >= 0 ? $finalCoins : 0,
			'health' => $this->adjustHealth($studentCharacter, $finalHealth)
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

	private function adjustHealth($studentCharacter, $finalHealth) {
		$maxStudentHealth = $this->getMaxStudentHealth($studentCharacter);
		if ($finalHealth > $maxStudentHealth)
			$finalHealth = $maxStudentHealth;
		elseif ($finalHealth < 0)
			$finalHealth = 0;
		return $finalHealth;
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
