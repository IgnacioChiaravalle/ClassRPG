<?php

namespace App\Http\Controllers\Teacher\ManageTeachers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralFunctions\ArrayHandlerController;
use App\Http\Controllers\User\UserManagementController;
use App\Http\Controllers\Teacher\ManageTeachers\TeacherDeletionController;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\User;

class TeacherManagerController extends Controller {
	public function __construct() {
		$this->middleware('adminTeacherAuth');
	}

	protected function getTeachers() {
		$teachers = Teacher::where('name', '!=' , Auth::user()->name)->get();
		$teacherUsers = array();
		foreach($teachers as $teacher) {
			array_push($teacherUsers, User::where('name', $teacher->name)->first());
			end($teacherUsers)->can_manage_teachers = $teacher->can_manage_teachers;
		}
		if (!empty($teacherUsers))
			return (new ArrayHandlerController)->quicksort($teacherUsers, 'user');
		else
			return null;
	}

	protected function updateCanManageTeachers($teacherName, $canManageTeachers) {
		Teacher::where('name', $teacherName)->first()->update([
			'can_manage_teachers' => $canManageTeachers
		]);
	}

	protected function deleteTeacher($teacherName) {
		(new TeacherDeletionController)->cascadeDeleteStudents(Teacher::where('name', $teacherName)->first());
		(new UserManagementController)->deleteUser(User::where('name', $teacherName)->first());
	}
}
