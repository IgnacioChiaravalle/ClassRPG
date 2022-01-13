<?php

namespace App\Http\Controllers\Teacher\ManageMissions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\ManageStudents\StudentDataForTeacherController;
use App\Models\Mission;
use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MissionAdditionController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	protected function addMission(Request $request, $studentName) {
		$this->validateRequest($request);
		Mission::create([
			'name' => $request->name,
			'teacher_student_relation_id' => $this->getTeacherStudentRelationID($studentName),
			'description' => $request->description,
			'damage_caused' => $request->damage_caused,
			'damage_period' => $request->damage_period,
			'max_health' => $request->max_health,
			'current_health' => $request->max_health,
			'start_date' => Carbon::parse($this->getDate()),
			'finish_date' => null,
			'coins_reward' => $request->coins_reward,
			'other_rewards' => $request->other_rewards,
			'archived' => false
		]);
		return Redirect::to("/manage-students/handle-student-data/$studentName")->with('success', "Misión asignada con éxito.");
	}

	public function validateRequest(Request $request) {
		$request->validate([
			'name' => ['required', 'string'],
			'description' => ['required', 'string'],
			'damage_caused' => ['required', 'numeric', 'min:0'],
			'damage_period' => ['required', 'string'],
			'max_health' => ['required', 'numeric', 'min:0'],
			'coins_reward' => ['required', 'numeric', 'min:0'],
			'other_rewards' => ['nullable']
		]);
	}

	private function getTeacherStudentRelationID($studentName) {
		$sDC = new StudentDataForTeacherController;
		return $sDC->getOrFail_TeacherStudentRelation($sDC->getUserName(), $studentName)->id;
	}

	private function getDate() {
		return date("Y-m-d");
	}
}