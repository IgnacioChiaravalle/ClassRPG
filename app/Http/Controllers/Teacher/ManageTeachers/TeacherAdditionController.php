<?php

namespace App\Http\Controllers\Teacher\ManageTeachers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserManagementController;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherAdditionController extends Controller {
	public function __construct() {
		$this->middleware('adminTeacherAuth');
	}

	protected function addTeacher(Request $request) {
		$uMC = new UserManagementController;
		$uMC->validateNewUserDataRequest($request);
		$uMC->createUser($request, 'teacher');
		$canManageTeachers = ($request->can_manage_teachers == null || $request->can_manage_teachers == false) ? false : true;
		Teacher::create([
			'name' => $request->name,
			'can_manage_teachers' => $canManageTeachers
		]);
		return redirect()->route('/manage-teachers')->with('success', "Docente añadido con éxito.");
	}
}
