<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\RPGClass;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;
use Illuminate\Http\Request;

class StudentWelcomeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getStudentWelcome($student) {
		$rpg_class = RPGClass::where('name', $student->rpg_class)->first();
		$weapon = Weapon::where('name', $student->weapon)->first();
		$item = Item::where('name', $student->item)->first();
		$damage = $rpg_class->base_damage + $weapon->added_damage + $item->added_damage;
		$armor = Armor::where('name', $student->armor)->first();
		return View::make('student.student_welcome')->with('student', $student)
													->with('damage', $damage)
													->with('weapon_damage', $weapon->added_damage)
													->with('item_damage', $item->added_damage)
													->with('item_health', $item->added_health)
													->with('armor_health', $armor->added_health);
	}
}
