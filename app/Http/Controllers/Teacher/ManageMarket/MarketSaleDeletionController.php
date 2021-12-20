<?php

namespace App\Http\Controllers\Teacher\ManageMarket;

use App\Http\Controllers\Controller;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;
use Illuminate\Http\Request;

class MarketSaleDeletionController extends Controller {
	protected function deleteSale($saleName) {
		$sale = Weapon::where('name', $saleName)->first();
		if (!$sale)
			$sale = Armor::where('name', $saleName)->first();
		if (!$sale)
			$sale = Item::where('name', $saleName)->first();
		$sale->delete();
	}
}
