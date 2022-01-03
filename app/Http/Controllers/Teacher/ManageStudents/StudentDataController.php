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

	public function getOrFail_TeacherStudentRelation($currentTeacherName, $studentName) {
		return Teacher_Student::where([
			['teacher_name', '=', $currentTeacherName],
			['student_name', '=', $studentName]
		])->firstOrFail();
	}
	public function getOtherTeachers($currentTeacherName, $studentName) {
		return Teacher_Student::where([
			['teacher_name', '!=', $currentTeacherName],
			['student_name', '=', $studentName]
		])->get();
	}

	protected function captureStudentData($studentName) {
		$teacherStudentRelation = $this->getOrFail_TeacherStudentRelation($this->getUserName(), $studentName);
		$studentCharacter = $this->getStudentCharacter($studentName);
		$maxStudentHealth = $this->getMaxStudentHealth($studentCharacter);
		return View::make('teacher.manage_students.handle_student_data')->with('teacher', $this->getTeacher())
																		->with('studentUser', $this->getStudentUser($studentName))
																		->with('studentCharacter', $studentCharacter)
																		->with('maxStudentHealth', $maxStudentHealth)
																		->with('weaponsForStudentClass', $this->getWearablesForStudentClass($studentCharacter->rpg_class, 'Weapon'))
																		->with('itemsForStudentClass', $this->getWearablesForStudentClass($studentCharacter->rpg_class, 'Item'))
																		->with('armorsForStudentClass', $this->getWearablesForStudentClass($studentCharacter->rpg_class, 'Armor'))
																		->with('studentNotes', $teacherStudentRelation->notes_on_student);
	}

	private function getUserName() {
		return Auth::user()->name;
	}
	private function getTeacher() {
		return Teacher::where('name', $this->getUserName())->first();
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
	private function getWearablesForStudentClass($rpgClass, $wearableType) {
		$modelName = "App\Models\\" . $wearableType;
		return $modelName::where('rpg_class', $rpgClass)->orderBy('name', 'asc')->get();
	}

	protected function editStudentData(Request $request, $studentName) {
		$teacherStudentRelation = $this->getOrFail_TeacherStudentRelation($this->getUserName(), $studentName);
		$this->validateStudentDataRequest($request);
		$studentCharacter = $this->getStudentCharacter($studentName);
		$finalCoins = $studentCharacter->coins + $request->coins;
		$finalHealth = $studentCharacter->health + $request->health;
		$studentCharacter->update([
			'coins' => $finalCoins >= 0 ? $finalCoins : 0,
			'health' => $this->adjustHealth($studentCharacter, $finalHealth),
			'weapon' => $request->weapon,
			'item' => $request->item,
			'armor' => $request->armor
		]);
		$teacherStudentRelation->update([
			'notes_on_student' => $request->notes_on_student
		]);
		return redirect()->route('/')->with('success', "Información actualizada con éxito.");
	}

	private function validateStudentDataRequest (Request $request) {
		$request->validate([
			'health' => ['numeric', 'integer'],
			'coins' => ['numeric', 'integer'],
			'weapon' => ['string'],
			'item' => ['string'],
			'armor' => ['string'],
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
