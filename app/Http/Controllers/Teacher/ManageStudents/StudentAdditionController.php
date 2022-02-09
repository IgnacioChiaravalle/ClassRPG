<?php

namespace App\Http\Controllers\Teacher\ManageStudents;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserManagementController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\RPGClass;
use App\Models\Student;
use App\Models\Teacher_Student;
use Illuminate\Http\Request;

class StudentAdditionController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	protected function createView() {
		return View::make('teacher.manage_students.add_student')->with('classes', RPGClass::orderBy('name', 'asc')->get());
	}

	protected function addStudent(Request $request) {
		$uMC = new UserManagementController;
		$this->validateRequest($request, $uMC);
		$this->createNewStudent($request, $uMC);
		return redirect()->route('/')->with('success', "Alumno añadido con éxito.");
	}

	private function validateRequest(Request $request, $uMC) {
		$uMC->validateNewUserDataRequest($request);
		$request->validate(['notes_on_student' => ['nullable', 'max:65,535']]);
	}
	
	private function createNewStudent(Request $request, $uMC) {
		$uMC->createUser($request, 'student');
		$this->createStudentCharacter($request);
		$this->createTeacherStudentRelation($request);
	}
	private function createStudentCharacter(Request $request) {
		$rpgClass = RPGClass::where('name', $request->rpg_class)->first();
		Student::create([
			'name' => $request->name,
			'rpg_class' => $rpgClass->name,
			'health' => $rpgClass->base_health,
			'weapon' => null,
			'item' => null,
			'armor' => null,
			'coins' => 10
		]);
	}
	private function createTeacherStudentRelation(Request $request) {
		Teacher_Student::create([
			'teacher_name' => Auth::user()->name,
			'student_name' => $request->name,
			'notes_on_student' => $request->notes_on_student
		]);
	}
}
