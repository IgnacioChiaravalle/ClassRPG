<?php

namespace App\Http\Controllers\Teacher\ManageMarket;

use App\Http\Controllers\Controller;
use App\Models\Weapon;
use App\Models\Item;
use App\Models\Armor;
use Redirect;
use Illuminate\Http\Request;

class MarketSaleAdditionController extends Controller {
	protected function addSale(Request $request, $rpgClass) {
		$this->validateRequest($request);
		$marketable = $request->marketable != null;
		$modelName = "App\Models\\" . $request->type;
		$modelName::create([
			'name' => $request->name,
			'rpg_class' => $rpgClass,
			'added_damage' => $request->added_damage,
			'added_health' => $request->added_health,
			'cost' => $request->cost,
			'marketable' => $marketable
		]);
		return Redirect::to("/manage-market/$rpgClass")->with('success', "Artículo añadido con éxito.");
	}

	private function validateRequest(Request $request) {
		$request->validate([
			'name' => ['required', 'string', 'unique:weapons', 'unique:armors', 'unique:items'],
			'added_damage' => ['numeric', 'min:0'],
			'added_health' => ['numeric', 'min:0'],
			'cost' => ['required', 'numeric', 'min:0']
		]);
	}
}
