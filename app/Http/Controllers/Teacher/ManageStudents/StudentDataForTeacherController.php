<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HealthValues\HealthValuesController;
use App\Http\Controllers\User\UserManagementController;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Teacher_Student;
use App\Models\Mission;

class StudentDataForTeacherController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	public function getOrFail_TeacherStudentRelation($currentTeacherName, $studentName) {
		return Teacher_Student::where([
			['teacher_name', '=', $currentTeacherName],
			['student_name', '=', $studentName]
		])->firstOrFail();
	}

	public function getOtherTeachers($currentTeacherName, $studentName) {
		return Teacher_Student::where([
			['teacher_name', '!=', $currentTeacherName],
			['student_name', '=', $studentName]
		])->get();
	}

	public function getUserName() {
		return Auth::user()->name;
	}

	public function getTeacher() {
		return Teacher::where('name', $this->getUserName())->first();
	}

	public function getStudentCharacter($studentName) {
		return Student::where('name', $studentName)->first();
	}

	public function getMaxStudentHealth($studentCharacter) {
		return (new HealthValuesController)->getMaxStudentHealth($studentCharacter);
	}

	public function getStudentUser($studentName) {
		return (new UserManagementController)->getUserByName($studentName);
	}

	public function getWearablesForStudentClass($rpgClass, $wearableType) {
		$modelName = "App\Models\\" . $wearableType;
		return $modelName::where('rpg_class', $rpgClass)->orderBy('cost', 'asc')->get();
	}

	public function getTeacherStudentMissionsByArchive($teacherStudentID, $archived) {
		return Mission::where('teacher_student_relation_id', $teacherStudentID)->where('archived', $archived)->orderBy('start_date', 'asc')->get();
	}
}
