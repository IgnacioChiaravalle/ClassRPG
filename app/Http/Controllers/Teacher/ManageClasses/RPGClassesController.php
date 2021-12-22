<?php

namespace App\Http\Controllers\Teacher\ManageClasses;

use App\Http\Controllers\Controller;
use App\Models\RPGClass;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RPGClassesController extends Controller {
	protected function getRPGClasses() {
		$rpg_classes = RPGClass::orderBy('name', 'asc')->get();
		foreach ($rpg_classes as $rpg_class)
			$rpg_class->users = Student::where('rpg_class', $rpg_class->name)->count();
		return (!empty($rpg_classes)) ? $rpg_classes : null;
	}

	protected function editClass(Request $request, $className) {
		if ($this->validateRequest($request)->fails())
			return back()->with('message', 'Los campos deben contener números mayores o iguales a 0 (cero).');
		$className = RPGClass::where('name', $className)->first();
		$className->update([
			'base_damage' => $request->base_damage,
			'base_health' => $request->base_health
		]);
		return back()->with('success', "Clase editada con éxito.");;
	}

	private function validateRequest(Request $request) {
		return Validator::make($request->all(), [
			'name' => ['string', 'unique:rpg_classes'],
			'base_damage' => ['numeric', 'min:0'],
			'base_health' => ['numeric', 'min:0']
		]);
	}

	protected function deleteClass($className) {
		RPGClass::where('name', $className)->first()->delete();
	}
}
