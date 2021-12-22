<?php

namespace App\Http\Controllers\Teacher\ManageMarket;

use App\Http\Controllers\Controller;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MarketSaleEditionController extends Controller {
	protected function updateMarketable($saleName, $marketable) {
		$sale = $this->getSale($saleName);
		$sale->update(['marketable' => $marketable]);
	}

	private function getSale($saleName) {
		$sale = Weapon::where('name', $saleName)->first();
		if (!$sale)
			$sale = Armor::where('name', $saleName)->first();
		if (!$sale)
			$sale = Item::where('name', $saleName)->first();
		return $sale;
	}

	protected function editSale(Request $request, $saleName) {
		if ($this->validateRequest($request)->fails())
			return back()->with('message', 'Los campos deben contener números mayores o iguales a 0 (cero).');
		$sale = $this->getSale($saleName);
		$sale->update([
			'added_damage' => $request->added_damage,
			'added_health' => $request->added_health,
			'cost' => $request->cost
		]);
		return back()->with('success', "Artículo editado con éxito.");;
	}

	private function validateRequest(Request $request) {
		return Validator::make($request->all(), [
			'added_damage' => ['numeric', 'min:0'],
			'added_health' => ['numeric', 'min:0'],
			'cost' => ['required', 'numeric', 'min:0']
		]);
	}
}
