<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserManagementController;
use App\Http\Controllers\GeneralFunctions\ListSortController;
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
		(new StudentDataController)->getOrFail_TeacherStudentRelation(Auth::user()->name, $studentName);
		$unrelatedTeachers = $this->getUnrelatedTeachers($studentName);
		$relatedTeachers = $this->getRelatedTeachers($studentName);
		if ($unrelatedTeachers != null && $relatedTeachers != null)
			return View::make('teacher.manage_students.share_to_teacher')->with('studentName', $studentName)->with('unrelatedTeachers', $unrelatedTeachers)->with('relatedTeachers', $relatedTeachers);
		elseif ($unrelatedTeachers != null)
			return View::make('teacher.manage_students.share_to_teacher')->with('studentName', $studentName)->with('unrelatedTeachers', $unrelatedTeachers);
		elseif ($relatedTeachers != null)
			return View::make('teacher.manage_students.share_to_teacher')->with('studentName', $studentName)->with('relatedTeachers', $relatedTeachers);
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
		return $this->returnQuicksortOrNull($unrelatedTeachers);
	}

	private function getRelatedTeachers($studentName) {
		$otherTeacher_Students = (new StudentDataController)->getOtherTeachers(Auth::user()->name, $studentName);
		$uMC = new UserManagementController;
		$relatedTeachers = array();
		foreach ($otherTeacher_Students as $teacher_student)
			array_push($relatedTeachers, $uMC->getUserByName($teacher_student->teacher_name));
		return $this->returnQuicksortOrNull($relatedTeachers);
	}

	private function returnQuicksortOrNull($array) {
		if (empty($array))
			return null;
		$array = (new ListSortController)->quicksort($array, 'user');
		return $array;
	}

	protected function shareStudent(Request $request, $studentName) {
		(new StudentDataController)->getOrFail_TeacherStudentRelation(Auth::user()->name, $studentName);
		Teacher_Student::create([
			'teacher_name' => $request->teacher_name,
			'student_name' => $studentName,
			'notes_on_student' => null
		]);
		return redirect()->route('/')->with('success', "Alumno compartido con éxito.");
	}
}
