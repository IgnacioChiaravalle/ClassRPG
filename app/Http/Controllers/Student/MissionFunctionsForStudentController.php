<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\StudentDataLookUpController;
use Carbon\Carbon;
use App\Models\Mission;

class MissionFunctionsForStudentController extends Controller {
	public function __construct() {
		$this->middleware('studentAuth');
	}

	protected function takeDamage($missionID) {
		$mission = Mission::where('id', $missionID)->first();
		$studentDamage = (new StudentDataLookUpController)->getStudentDamage();
		$mission->update(['current_health' => $this->getFinalHealth($mission, $studentDamage)]);
		$success = ($mission->current_health > 0) ? "¡Golpe certero!" : "¡Golpe certero! ¡¡Venciste la misión!!";
		return back()->with('success', $success);
	}
	
	private function getFinalHealth($mission, $studentDamage) {
		$finalHealth = $mission->current_health - $studentDamage;
		if ($finalHealth <= 0) {
			$this->completeMission($mission);
			return 0;
		}
		else
			return $finalHealth;
	}

	public function completeMission($mission) {
		$mission->update(['finish_date' => Carbon::parse(date("Y-m-d"))]);
	}

}
