<?php

namespace App\Http\Controllers\Teacher\ManageTeachers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralFunctions\ArrayHandlerController;
use App\Http\Controllers\Teacher\ManageStudents\StudentDataController;
use App\Http\Controllers\User\UserManagementController;
use App\Models\Teacher;
use App\Models\Teacher_Student;
use Illuminate\Http\Request;

class TeacherDeletionController extends Controller {
	public function cascadeDeleteStudents(Teacher $teacher) {
		$myStudents = Teacher_Student::where('teacher_name', $teacher->name)->get();
		$toDeleteStudents = array();
		foreach ($myStudents as $student_and_me) {
			$otherTeachers = $sDC->getOtherTeachers($teacher->name, $student_and_me->student_name);
			$aHC = new ArrayHandlerController;
			if ($aHC->findSize($otherTeachers) == 0) {
				$uMC = new UserManagementController;
				$uMC->deleteUser($uMC->getUserByName($student_and_me->student_name));
			}
		}
	}
}
