<?php

namespace App\Http\Controllers\Teacher\ManageMissions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\ManageStudents\StudentDataController;
use App\Models\Mission;

class MissionFunctionsController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	private function getStudentCharacter($studentName) {
		return (new StudentDataController)->getStudentCharacter($studentName);
	}
	public function getMission($missionID) {
		return Mission::where('id', $missionID)->first();
	}

	protected function doDamage($studentName, $missionID) {
		$studentCharacter = $this->getStudentCharacter($studentName);
		$missionDamage = $this->getMission($missionID)->damage_caused;
		$studentCharacter->update(['health' => $this->adjustHealth($studentCharacter->health, $missionDamage)]);
		return back()->with('success', "Daño ejercido.");
	}
	private function adjustHealth($studentHealth, $missionDamage) {
		$finalHealth = $studentHealth - $missionDamage;
		return ($finalHealth >= 0) ? $finalHealth : 0;
	}

	protected function giveCoinsReward($studentName, $missionID) {
		$studentCharacter = $this->getStudentCharacter($studentName);
		$missionCoinsReward = $this->getMission($missionID)->coins_reward;
		$studentCharacter->update(['coins' => $studentCharacter->coins + $missionCoinsReward]);
		return back()->with('success', "Monedas entregadas.");
	}

	protected function setArchive($studentName, $missionID, $archive) {
		$this->getMission($missionID)->update(['archived' => $archive]);
		$success = ($archive == "true") ? "Misión añadida al archivo de " . $studentName . "." : "Misión removida del archivo de " . $studentName . ".";
		return back()->with('success', $success);
	}
}
