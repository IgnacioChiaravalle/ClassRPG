<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralFunctions\ArrayHandlerController;
use App\Http\Controllers\User\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Teacher_Student;
use Illuminate\Http\Request;

class DeleteStudentController extends Controller {
	protected function createView() {
		$teacherStudents = Teacher_Student::where('teacher_name', Auth::user()->name)->get();
		$studentUsers = array();
		foreach ($teacherStudents as $tS)
			array_push($studentUsers, User::where('name', $tS->student_name)->first());
		$aHC = new ArrayHandlerController;
		if ($aHC->findSize($studentUsers) > 0) {
			$studentUsers = $aHC->quicksort($studentUsers, 'user');
			return View::make('teacher.manage_students.delete_student')->with('student_users', $studentUsers);
		}
		else
			return View::make('teacher.manage_students.delete_student');
	}

	protected function deleteStudent(Request $request) {
		$request->validate(['name' => ['required', 'string']]);
		(new UserManagementController)->deleteUser(User::where('name', $request->name)->first());
		return redirect()->route('/')->with('message', "Alumno eliminado con éxito.");
	}
}
