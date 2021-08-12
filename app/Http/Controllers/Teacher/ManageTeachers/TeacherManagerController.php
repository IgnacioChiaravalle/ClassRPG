<?php

namespace App\Http\Controllers\Teacher\ManageTeachers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class TeacherManagerController extends Controller {
	protected function createView() {
		$teachers = Teacher::where('name', '!=' , Auth::user()->name)->get();
		return View::make('teacher.manage_teachers.show_teachers')->with('teachers', $teachers);
	}
}
