<?php

namespace App\Http\Controllers\Teacher\ManageTeachers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralFunctions\ListSortController;
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
		$uMC = new UserManagementController;
		foreach($teachers as $teacher) {
			array_push($teacherUsers, $uMC->getUserByName($teacher->name));
			end($teacherUsers)->can_manage_teachers = $teacher->can_manage_teachers;
		}
		if (!empty($teacherUsers))
			return (new ListSortController)->quicksort($teacherUsers, 'user');
		else
			return null;
	}

	protected function updateCanManageTeachers($teacherName, $canManageTeachers) {
		Teacher::where('name', $teacherName)->first()->update([
			'can_manage_teachers' => $canManageTeachers
		]);
	}

	protected function deleteTeacher($teacherName) {
		(new TeacherDeletionController)->cascadeDeleteStudents($teacherName);
		$uMC = new UserManagementController;
		$uMC->deleteUser($uMC->getUserByName($teacherName));
	}
}
