<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralFunctions\ListSortController;
use App\Http\Controllers\GeneralFunctions\HealthValuesController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\RPGClass;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;

class MarketController extends Controller {
	public function __construct() {
		$this->middleware('studentAuth');
	}

	private function getStudent() {
		return Student::where('name', Auth::user()->name)->first();
	}

	protected function getMarket() {
		$student = $this->getStudent();

		$weapons = Weapon::where('rpg_class', $student->rpg_class)->where('name', '!=', $student->weapon)->where('marketable', true)->get();
		$this->addTypeToAllElements($weapons, 'Arma');
		$items = Item::where('rpg_class', $student->rpg_class)->where('name', '!=', $student->item)->where('marketable', true)->get();
		$this->addTypeToAllElements($items, 'Ítem');
		$armors = Armor::where('rpg_class', $student->rpg_class)->where('name', '!=', $student->armor)->where('marketable', true)->get();
		$this->addTypeToAllElements($armors, 'Armadura');
		
		$onSaleList = $this->putTogether($weapons, $items, $armors);
		if (!empty($onSaleList)) {
			$onSaleList = (new ListSortController)->quicksort($onSaleList, 'sale');
			return View::make('student.market')->with('student', $student)->with('onSaleList', $onSaleList);
		}
		else
			return View::make('student.market')->with('student', $student);
	}

		private function addTypeToAllElements($list, $type) {
			foreach ($list as $toAdd)
				$toAdd->type = $type;
		}
		public function putTogether($array1, $array2, $array3) {
			$toReturn = array();
			foreach($array1 as $a1)
				$toReturn[] = $a1;
			foreach($array2 as $a2)
				$toReturn[] = $a2;
			foreach($array3 as $a3)
				$toReturn[] = $a3;
			return $toReturn;
		}

	protected function buyItem($saleName, $saleCost) {
		$student = $this->getStudent();
		if ($student->coins < $saleCost)
			return back()->with('message', "¡No tenés suficiente oro para comprar esto!");

		$sale = Weapon::where('name', $saleName)->first();
		$type = 'weapon';
		$newHealth = $student->health;
		if ($sale == null) {
			$hVC = new HealthValuesController;
			$sale = Item::where('name', $saleName)->first();
			if ($sale != null) {
				$type = 'item';
				$newHealth += ($sale->added_health - $hVC->getStudentItemHealth($student));
			}
			else {
				$sale = Armor::where('name', $saleName)->first();
				$type = 'armor';
				$newHealth += ($sale->added_health - $hVC->getStudentArmorHealth($student));
			}
		}

		$student->update([
			'coins' => $student->coins - $saleCost,
			$type => $sale->name,
			'health' => $newHealth
		]);

		return redirect()->route('/');
	}
	
	protected function healStudent($healCost) {
		$student = $this->getStudent();
		if ($student->coins < $healCost)
			return back()->with('message', "¡No tenés suficiente oro para curarte!");

		$maxStudentHealth = (new HealthValuesController)->getMaxStudentHealth($student);
		if ($student->health == $maxStudentHealth)
			return back()->with('message', "¡Ya tenés tu salud máxima!");
		$student->update([
			'coins' => $student->coins - $healCost,
			'health' => $maxStudentHealth
		]);
		return redirect()->route('/');
	}
}
