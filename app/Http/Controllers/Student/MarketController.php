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

	protected function getMarket() {
		$student = Student::where('name', Auth::user()->name)->first();

		$weapons = Weapon::where('rpg_class', $student->rpg_class)->get();
		$this->addType($weapons, 'Arma');
		$items = Item::where('rpg_class', $student->rpg_class)->get();
		$this->addType($items, 'Ítem');
		$armors = Armor::where('rpg_class', $student->rpg_class)->get();
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
}
