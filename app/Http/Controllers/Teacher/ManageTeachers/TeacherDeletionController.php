<?php

namespace App\Http\Controllers\Teacher\ManageTeachers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\ManageStudents\StudentDataForTeacherController;
use App\Http\Controllers\User\UserManagementController;
use App\Models\Teacher_Student;
use Illuminate\Http\Request;

class TeacherDeletionController extends Controller {
	public function cascadeDeleteStudents($teacherName) {
		$myStudents = Teacher_Student::where('teacher_name', $teacherName)->get();
		$uMC = new UserManagementController;
		foreach ($myStudents as $student_and_me) {
			$otherTeachers = (new StudentDataForTeacherController)->getOtherTeachers($teacherName, $student_and_me->student_name);
			if ($otherTeachers->isEmpty())
				$uMC->deleteUser($uMC->getUserByName($student_and_me->student_name));
		}
	}
}
