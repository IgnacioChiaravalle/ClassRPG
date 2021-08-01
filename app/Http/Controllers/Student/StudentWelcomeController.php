<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralFunctions\HealthValuesController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\RPGClass;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;

class StudentWelcomeController extends Controller {
	public function __construct() {
		$this->middleware('studentAuth');
	}

	public function getStudentWelcome($student) {
		$rpg_class = RPGClass::where('name', $student->rpg_class)->first();
		
		$weapon = Weapon::where('name', $student->weapon)->first();
		$weapon_damage = $weapon != null ? $weapon->added_damage : 0;
		$item = Item::where('name', $student->item)->first();
		$item_damage = $item != null ? $item->added_damage : 0;
		$item_health = $item != null ? $item->added_health : 0;
		$armor = Armor::where('name', $student->armor)->first();
		$armor_health = $armor != null ? $armor->added_health : 0;
		$max_health = (new HealthValuesController)->getMaxStudentHealth($student);

		$damage = $rpg_class->base_damage + $weapon_damage + $item_damage;
		return View::make('student.student_welcome')->with('student', $student)
													->with('damage', $damage)
													->with('weapon_damage', $weapon_damage)
													->with('item_damage', $item_damage)
													->with('item_health', $item_health)
													->with('armor_health', $armor_health)
													->with('max_health', $max_health);
	}
}
