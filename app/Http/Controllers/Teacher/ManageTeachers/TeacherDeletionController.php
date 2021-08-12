<?php

namespace App\Http\Controllers\Teacher\ManageTeachers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralFunctions\ArrayHandlerController;
use App\Http\Controllers\User\UserManagementController;
use App\Models\Teacher;
use App\Models\Teacher_Student;
use Illuminate\Http\Request;

class TeacherDeletionController extends Controller {
	public function cascadeDeleteStudents(Teacher $teacher) {
		$myStudents = Teacher_Student::where('teacher_name', $teacher->name)->get();
		$toDeleteStudents = array();
		foreach ($myStudents as $me_student) {
			$otherTeachers = Teacher_Student::where([
				['student_name', '=', $me_student->student_name],
				['teacher_name', '!=', $teacher->name]
			])->get();
			$aHC = new ArrayHandlerController;
			if ($aHC->findSize($otherTeachers) == 0) {
				$uMC = new UserManagementController;
				$uMC->deleteUser($uMC->getUserByName($me_student->student_name));
			}
		}
	}
}
