<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Teacher\ManageStudents\StudentDataForTeacherController;
use Illuminate\Http\Request;

class StudentEditionController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	private function makeStudentDataForTeacherController() {
		return new StudentDataForTeacherController;
	}

	protected function createView($studentName) {
		$sDC = $this->makeStudentDataForTeacherController();
		$teacherStudentRelation = $sDC->getOrFail_TeacherStudentRelation($sDC->getUserName(), $studentName);
		$studentCharacter = $sDC->getStudentCharacter($studentName);
		return View::make('teacher.manage_students.handle_student_data')->with('teacher', $sDC->getTeacher())
																		->with('studentUser', $sDC->getStudentUser($studentName))
																		->with('studentCharacter', $studentCharacter)
																		->with('maxStudentHealth', $sDC->getMaxStudentHealth($studentCharacter))
																		->with('weaponsForStudentClass', $sDC->getWearablesForStudentClass($studentCharacter->rpg_class, 'Weapon'))
																		->with('itemsForStudentClass', $sDC->getWearablesForStudentClass($studentCharacter->rpg_class, 'Item'))
																		->with('armorsForStudentClass', $sDC->getWearablesForStudentClass($studentCharacter->rpg_class, 'Armor'))
																		->with('missions', $sDC->getTeacherStudentMissionsByArchive($teacherStudentRelation->id, false))
																		->with('studentNotes', $teacherStudentRelation->notes_on_student);
	}

	protected function editStudentData(Request $request, $studentName) {
		$sDC = $this->makeStudentDataForTeacherController();
		$teacherStudentRelation = $sDC->getOrFail_TeacherStudentRelation($sDC->getUserName(), $studentName);
		$this->validateStudentDataRequest($request);
		$studentCharacter = $sDC->getStudentCharacter($studentName);
		$finalCoins = $studentCharacter->coins + $request->coins;
		$finalHealth = $studentCharacter->health + $request->health;
		$studentCharacter->update([
			'coins' => $finalCoins >= 0 ? $finalCoins : 0,
			'health' => $this->adjustHealth($sDC, $studentCharacter, $finalHealth),
			'weapon' => ($request->weapon != "null") ? $request->weapon : null,
			'item' => ($request->item != "null") ? $request->item : null,
			'armor' => ($request->armor != "null") ? $request->armor : null
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

	private function adjustHealth($sDC, $studentCharacter, $finalHealth) {
		$maxStudentHealth = $sDC->getMaxStudentHealth($studentCharacter);
		if ($finalHealth > $maxStudentHealth)
			$finalHealth = $maxStudentHealth;
		elseif ($finalHealth < 0)
			$finalHealth = 0;
		return $finalHealth;
	}
}
