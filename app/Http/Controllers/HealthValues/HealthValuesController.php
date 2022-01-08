<?php

namespace App\Http\Controllers\HealthValues;

use App\Http\Controllers\Controller;
use App\Models\RPGClass;
use App\Models\Item;
use App\Models\Armor;

class HealthValuesController extends Controller {
	public function getMaxStudentHealth($student) {
		$rpg_class = RPGClass::where('name', $student->rpg_class)->first();
		return $rpg_class->base_health + $this->getStudentItemHealth($student) + $this->getStudentArmorHealth($student);
	}

	public function getStudentItemHealth($student) {
		return $this->getHealthValue(Item::where('name', $student->item)->first());
	}
	public function getStudentArmorHealth($student) {
		return $this->getHealthValue(Armor::where('name', $student->armor)->first());
	}
		private function getHealthValue($inUse) {
			$toReturn = $inUse != null ? $inUse->added_health : 0;
			return $toReturn;
		}
}
