<?php

namespace App\Http\Controllers\Teacher\ManageMissions;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Teacher\ManageMissions\MissionFunctionsForTeacherController;
use App\Http\Controllers\Teacher\ManageMissions\MissionAdditionController;
use Redirect;
use Illuminate\Http\Request;

class MissionEditionController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	protected function createView($studentName, $missionID) {
		$mission = (new MissionFunctionsForTeacherController)->getMission($missionID);
		return View::make('teacher.manage_missions.edit_mission')->with('mission', $mission);
	}

	protected function editMission(Request $request, $studentName, $missionID) {
		(new MissionAdditionController)->validateRequest($request);
		$request->validate(['current_health' => ['required', 'numeric', 'min:0']]);
		(new MissionFunctionsForTeacherController)->getMission($missionID)->update([
			'name' => $request->name,
			'description' => $request->description,
			'damage_caused' => $request->damage_caused,
			'damage_period' => $request->damage_period,
			'max_health' => $request->max_health,
			'current_health' => $request->current_health,
			'coins_reward' => $request->coins_reward,
			'other_rewards' => $request->other_rewards
		]);
		return Redirect::to("/manage-students/handle-student-data/$studentName")->with('success', "Misión editada con éxito.");
	}
}