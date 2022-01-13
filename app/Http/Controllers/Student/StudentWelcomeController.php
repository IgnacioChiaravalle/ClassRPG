<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HealthValues\HealthValuesController;
use App\Http\Controllers\Student\StudentDataLookUpController;
use Illuminate\Support\Facades\View;
use App\Models\RPGClass;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;
use App\Models\Student;

class StudentWelcomeController extends Controller {
	public function __construct() {
		$this->middleware('studentAuth');
	}

	public function getStudentWelcome(Student $student) {
		$sDLUC = new StudentDataLookUpController;

		$weapon_damage = $sDLUC->getWeaponAddedDamage($sDLUC->getWeapon($student));
		$item_damage = $sDLUC->getItemAddedDamage($sDLUC->getItem($student));
		$item_health = $sDLUC->getItemAddedHealth($sDLUC->getItem($student));
		$armor_health = $sDLUC->getArmorAddedHealth($sDLUC->getArmor($student));
		$damage = $sDLUC->getStudentDamage(
											$sDLUC->getRPGClassBaseDamage($sDLUC->getRPGClass($student)),
											$weapon_damage,
											$item_damage
										);
		$max_health = (new HealthValuesController)->getMaxStudentHealth($student);
		$missions = $sDLUC->getMissions($student);

		return View::make('student.student_welcome')->with('student', $student)
													->with('damage', $damage)
													->with('weapon_damage', $weapon_damage)
													->with('item_damage', $item_damage)
													->with('item_health', $item_health)
													->with('armor_health', $armor_health)
													->with('max_health', $max_health)
													->with('missions', $missions);
	}
}
