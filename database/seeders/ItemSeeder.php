<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
	public function run() {
		$this->insertIntoTable([
			'Escudo de Madera',
			'Warrior',
			'2',
			'6',
			'3'
		]);
		$this->insertIntoTable([
			'Trampa para Osos',
			'Rogue',
			'0',
			'3',
			'10'
		]);
		$this->insertIntoTable([
			'Collar Mágico',
			'Rogue',
			'9',
			'4',
			'15'
		]);
	}

	private function insertIntoTable(array $data) {
		DB::table('items')->insert([
			'name' => $data[0],
			'rpg_class' => $data[1],
			'added_health' => $data[2],
			'added_damage' => $data[3],
			'cost' => $data[4]
		]);
	}
}
