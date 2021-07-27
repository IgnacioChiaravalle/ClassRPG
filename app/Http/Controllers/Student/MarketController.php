<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;
use Illuminate\Http\Request;

class MarketController extends Controller {
	public function __construct() {
		$this->middleware('studentAuth');
	}

	private function getStudent() {
		return Student::where('name', Auth::user()->name)->first();
	}

	protected function getMarket() {
		$student = $this->getStudent();

		$weapons = Weapon::where('rpg_class', $student->rpg_class)->where('name', '!=', $student->weapon)->get();
		$this->addType($weapons, 'Arma');
		$items = Item::where('rpg_class', $student->rpg_class)->where('name', '!=', $student->item)->get();
		$this->addType($items, 'Ítem');
		$armors = Armor::where('rpg_class', $student->rpg_class)->where('name', '!=', $student->armor)->get();
		$this->addType($armors, 'Armadura');
		
		$onSaleList = $this->putTogether($weapons, $items, $armors);
		$onSaleList = $this->quicksort($onSaleList);
		return View::make('student.market')->with('student', $student)->with('onSaleList', $onSaleList);
	}

		private function addType($list, $type) {
			foreach($list as $toAdd)
				$toAdd->type = $type;
		}

		private function putTogether($array1, $array2, $array3) {
			$toReturn = array();
			foreach($array1 as $a1)
				$toReturn[] = $a1;
			foreach($array2 as $a2)
				$toReturn[] = $a2;
			foreach($array3 as $a3)
				$toReturn[] = $a3;
			return $toReturn;
		}

		private function quicksort($list) {
			$loe = $gt = array();
			if ($this->findSize($list) < 2)
				return $list;
			
			$pivot_key = key($list);
			$pivot = array_shift($list);
			foreach ($list as $element) {
				if($element->cost <= $pivot->cost)
					$loe[] = $element;
				elseif ($element->cost > $pivot->cost)
					$gt[] = $element;	
			}
			
			return array_merge($this->quicksort($loe),array($pivot_key=>$pivot),$this->quicksort($gt));
		}

		private function findSize($list) {
			$size = 0;
			foreach ($list as $l)
				$size++;
			return $size;
		}

	protected function buyItem($saleName, $saleCost) {
		$student = $this->getStudent();
		if ($student->coins < $saleCost)
			return back()->with('message', "¡No tenés suficiente oro para comprar esto!.");

		$sale = Weapon::where('name', $saleName)->first();
		$type = 'weapon';
		$newHealth = $student->health;
		if ($sale == null) {
			$sale = Item::where('name', $saleName)->first();
			if ($sale != null) {
				$type = 'item';
				$newHealth += ($sale->added_health - $this->getStudentItemHealth($student));
			}
			else {
				$sale = Armor::where('name', $saleName)->first();
				$type = 'armor';
				$newHealth += ($sale->added_health - $this->getStudentArmorHealth($student));
			}
		}

		$student->update([
			'coins' => $student->coins - $sale->cost,
			$type => $sale->name,
			'health' => $newHealth
		]);

		return redirect()->route('/');
	}
		
		private function getStudentItemHealth($student) {
			return $this->getHealthValue(Item::where('name', $student->item)->first());
		}
		private function getStudentArmorHealth($student) {
			return $this->getHealthValue(Armor::where('name', $student->armor)->first());
		}
			private function getHealthValue($inUse) {
				$toReturn = $inUse != null ? $inUse->added_health : 0;
				return $toReturn;
			}
}
