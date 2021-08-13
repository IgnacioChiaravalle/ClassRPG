<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserManagementController;
use App\Http\Controllers\GeneralFunctions\ArrayHandlerController;
use App\Http\Controllers\Teacher\ManageStudents\StudentDataController;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher_Student;
use Illuminate\Http\Request;

class StudentUserController extends Controller {
	protected function editStudentUserEmail(Request $request, $studentName) {
		$uMC = new UserManagementController;
		$uMC->editUserEmail($request, $uMC->getUserByName($studentName));
		return redirect()->route('/');
	}

	protected function deleteStudent($studentName) {
		$sDC = new StudentDataController;
		$teacherStudentRelation = $sDC->getOrFail_TeacherStudentRelation($studentName);
		$otherTeachers = $sDC->getOtherTeachers($studentName);
		$aHC = new ArrayHandlerController;
		if ($aHC->findSize($otherTeachers) >= 1)
			$teacherStudentRelation->delete();
		else {
			$uMC = new UserManagementController;
			$uMC->deleteUser($uMC->getUserByName($studentName));
		}
		return redirect()->route('/')->with('success', "Alumno eliminado con éxito.");
	}	
}
