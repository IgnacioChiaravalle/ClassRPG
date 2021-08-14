<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserManagementController;
use App\Http\Controllers\Teacher\ManageStudents\StudentDataController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentUserController extends Controller {
	protected function editStudentUserEmail(Request $request, $studentName) {
		$uMC = new UserManagementController;
		$uMC->editUserEmail($request, $uMC->getUserByName($studentName));
		return redirect()->route('/');
	}

	protected function deleteStudent($studentName) {
		$sDC = new StudentDataController;
		$currentTeacherName = Auth::user()->name;
		$teacherStudentRelation = $sDC->getOrFail_TeacherStudentRelation($currentTeacherName, $studentName);
		$otherTeachers = $sDC->getOtherTeachers($currentTeacherName, $studentName);
		if (!$otherTeachers->isEmpty())
			$teacherStudentRelation->delete();
		else {
			$uMC = new UserManagementController;
			$uMC->deleteUser($uMC->getUserByName($studentName));
		}
		return redirect()->route('/')->with('success', "Alumno eliminado con éxito.");
	}
}
