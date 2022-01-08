<?php

namespace App\Http\Controllers\Teacher\ManageMarket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ListSort\ListSortController;
use App\Http\Controllers\Student\MarketController;
use Illuminate\Support\Facades\View;
use App\Models\RPGClass;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;
use App\Models\Student;
use Illuminate\Http\Request;

class MarketStockController extends Controller {
	public function __construct() {
		$this->middleware('teacherAuth');
	}

	protected function createView() {
		$rpg_classes = RPGClass::orderBy('name', 'asc')->get();
		return View::make('teacher.manage_market.class_picker')->with('rpgClasses', $rpg_classes);
	}

	protected function getClassStock($className) {
		$mC = new MarketController;

		$weapons = Weapon::where('rpg_class', $className)->get();
		$this->addTypeAndUsersToAllElements($weapons, 'Arma', 'weapon');
		$items = Item::where('rpg_class', $className)->get();
		$this->addTypeAndUsersToAllElements($items, 'Ítem', 'item');
		$armors = Armor::where('rpg_class', $className)->get();
		$this->addTypeAndUsersToAllElements($armors, 'Armadura', 'armor');
		
		$onSaleList = $mC->putTogether($weapons, $items, $armors);
		if (!empty($onSaleList))
			return (new ListSortController)->quicksort($onSaleList, 'sale');
		else
			return null;
	}
		private function addTypeAndUsersToAllElements($list, $typeName, $type) {
			foreach ($list as $sale) {
				$sale->type = $typeName;
				$sale->users = Student::where($type, $sale->name)->count();
			}
		}
}
