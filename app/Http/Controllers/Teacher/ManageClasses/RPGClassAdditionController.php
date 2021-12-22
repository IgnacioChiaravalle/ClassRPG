<?php

namespace App\Http\Controllers\Teacher\ManageClasses;

use App\Http\Controllers\Controller;
use App\Models\RPGClass;
use Redirect;
use Illuminate\Http\Request;

class RPGClassAdditionController extends Controller {
	protected function addClass(Request $request) {
		$this->validateRequest($request);
		RPGClass::create([
			'name' => $request->name,
			'base_damage' => $request->base_damage,
			'base_health' => $request->base_health
		]);
		return Redirect::to("/manage-classes")->with('success', "Clase añadida con éxito.");
	}

	private function validateRequest(Request $request) {
		$request->validate([
			'name' => ['required', 'string', 'unique:rpg_classes'],
			'base_damage' => ['required', 'numeric', 'min:0'],
			'base_health' => ['required', 'numeric', 'min:0']
		]);
	}
}
