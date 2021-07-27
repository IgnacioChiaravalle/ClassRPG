<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeacherWelcomeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getTeacherWelcome($teacher) {
		return View::make('teacher.teacher_welcome');		
	}
}
