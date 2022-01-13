<?php

namespace App\Http\Controllers\Teacher\ManageMissions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\ManageMissions\MissionFunctionsForTeacherController;

class MissionDeletionController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	protected function deleteMission($studentName, $missionID) {
		(new MissionFunctionsForTeacherController)->getMission($missionID)->delete();
		return back()->with('success', "Misión eliminada con éxito.");
	}
}
