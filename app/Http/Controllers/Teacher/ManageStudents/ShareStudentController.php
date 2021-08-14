<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserManagementController;
use App\Http\Controllers\GeneralFunctions\ArrayHandlerController;
use App\Http\Controllers\Teacher\ManageStudents\StudentDataController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Teacher_Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ShareStudentController extends Controller {
	protected function createView($studentName) {
		$unrelatedTeachers = $this->getUnrelatedTeachers($studentName);
		if ($unrelatedTeachers != null)
			return View::make('teacher.manage_students.share_to_teacher')->with('studentName', $studentName)->with('unrelatedTeachers', $unrelatedTeachers);
		else
			return View::make('teacher.manage_students.share_to_teacher')->with('studentName', $studentName);
	}

	private function getUnrelatedTeachers($studentName) {
		$otherTeachers = Teacher::where('name', '!=', Auth::user()->name)->get();
		$unrelatedTeachers = array();
		$sDC = new StudentDataController;
		$uMC = new UserManagementController;
		foreach ($otherTeachers as $teacher) {
			try { $sDC->getOrFail_TeacherStudentRelation($teacher->name, $studentName); }
			catch (ModelNotFoundException $ex) {
				array_push($unrelatedTeachers, $uMC->getUserByName($teacher->name));
			}
		}
		if (empty($unrelatedTeachers))
			return null;
		$unrelatedTeachers = (new ArrayHandlerController)->quicksort($unrelatedTeachers, 'user');
		return $unrelatedTeachers;
	}

	protected function shareStudent(Request $request, $studentName) {
		Teacher_Student::create([
			'teacher_name' => $request->teacher_name,
			'student_name' => $studentName,
			'notes_on_student' => null
		]);
		return redirect()->route('/')->with('success', "Alumno compartido con éxito.");
	}
}
