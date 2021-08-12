<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserManagementController;
use App\Http\Controllers\GeneralFunctions\ArrayHandlerController;
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
		$otherTeachers = Teacher_Student::where([
			['student_name', '=', $studentName],
			['teacher_name', '!=', Auth::user()->name]
		])->get();
		$aHC = new ArrayHandlerController;
		if ($aHC->findSize($otherTeachers) >= 1) {
			$teacher_student_relation = Teacher_Student::where([
				['student_name', '=', $studentName],
				['teacher_name', '=', Auth::user()->name]
			])->first();
			$teacher_student_relation->delete();
		}
		else {
			$uMC = new UserManagementController;
			$uMC->deleteUser($uMC->getUserByName($studentName));
		}
		return redirect()->route('/')->with('success', "Alumno eliminado con éxito.");
	}
}
