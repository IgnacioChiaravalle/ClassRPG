<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ListSort\ListSortController;
use App\Models\RPGClass;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;
use App\Models\Student;
use App\Models\Teacher_Student;
use App\Models\Mission;

class StudentDataLookUpController extends Controller {
	private $student = null;

	public function __construct() {
		$this->middleware('studentAuth');
	}

	public function getStudent() {
		$this->student = ($this->student == null) ? Student::where('name', Auth::user()->name)->first() : $this->student;
		return $this->student;
	}

	public function getRPGClass($student = null) {
		$student = ($student == null) ? $this->getStudent() : $student;
		return RPGClass::where('name', $student->rpg_class)->first();
	}
	public function getRPGClassBaseDamage($rpgClass = null) {
		$rpgClass = ($rpgClass == null) ? $this->getRPGClass() : $rpgClass;
		return $rpgClass->base_damage;
	}

	public function getWeapon($student = null) {
		$student = ($student == null) ? $this->getStudent() : $student;
		return Weapon::where('name', $student->weapon)->first();
	}
	public function getWeaponAddedDamage($weapon = null) {
		$weapon = ($weapon == null) ? $this->getWeapon() : $weapon;
		return ($weapon != null) ? $weapon->added_damage : 0;
	}

	public function getArmor($student = null) {
		$student = ($student == null) ? $this->getStudent() : $student;
		return Armor::where('name', $student->armor)->first();
	}
	public function getArmorAddedHealth($armor = null) {
		$armor = ($armor == null) ? $this->getArmor() : $armor;
		return ($armor != null) ? $armor->added_health : 0;
	}

	public function getItem($student = null) {
		$student = ($student == null) ? $this->getStudent() : $student;
		return Item::where('name', $student->item)->first();
	}
	public function getItemAddedDamage($item = null) {
		$item = ($item == null) ? $this->getItem() : $item;
		return ($item != null) ? $item->added_damage : 0;
	}
	public function getItemAddedHealth($item = null) {
		$item = ($item == null) ? $this->getItem() : $item;
		return ($item != null) ? $item->added_health : 0;
	}

	public function getStudentDamage($rpgClassBaseDamage = null, $weaponDamage = null, $itemDamage = null) {
		$rpgClassBaseDamage = ($rpgClassBaseDamage == null) ? $this->getRPGClassBaseDamage() : $rpgClassBaseDamage;
		$weaponDamage = ($weaponDamage == null) ? $this->getWeaponAddedDamage() : $weaponDamage;
		$itemDamage = ($itemDamage == null) ? $this->getItemAddedDamage() : $itemDamage;
		return $rpgClassBaseDamage + $weaponDamage + $itemDamage;
	}

	public function getMissions($student = null) {
		$student = ($student == null) ? $this->getStudent() : $student;
		$teacherStudentRelations = Teacher_Student::where('student_name', $student->name)->get();
		$missions = array();
		foreach ($teacherStudentRelations as $tSR) {
			$teacherMissions = Mission::where('teacher_student_relation_id', $tSR->id)->where('archived', false)->get();
			foreach ($teacherMissions as $tM)
				array_push($missions, $tM);
		}
		return (new ListSortController)->quicksort($missions, 'start_date');
	}
}
