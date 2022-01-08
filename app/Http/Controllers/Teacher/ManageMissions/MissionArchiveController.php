<?php

namespace App\Http\Controllers\Teacher\ManageMissions;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Teacher\ManageStudents\StudentDataController;

class MissionArchiveController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	protected function createView($studentName) {
		$sDC = new StudentDataController;
		$teacherStudentRelation = $sDC->getOrFail_TeacherStudentRelation($sDC->getUserName(), $studentName);
		$missions = $sDC->getTeacherStudentMissionsByArchive($teacherStudentRelation->id, true);
		if (!$missions->isEmpty())
			return View::make('teacher.manage_missions.student_missions_archive')->with('studentName', $studentName)->with('missions', $missions);
		else
			return View::make('teacher.manage_missions.student_missions_archive')->with('studentName', $studentName);
	}
}
