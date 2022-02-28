<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder {
	public function run() {
		$this->insertIntoTable([
			'Escudo de Madera',
			'Guerrero',
			'2',
			'6',
			'3',
			'true'
		]);
		$this->insertIntoTable([
			'Trampa para Osos',
			'Pícaro',
			'0',
			'3',
			'10',
			'true'
		]);
		$this->insertIntoTable([
			'Collar Mágico',
			'Pícaro',
			'9',
			'4',
			'15',
			'true'
		]);
	}

	private function insertIntoTable(array $data) {
		DB::table('items')->insert([
			'name' => $data[0],
			'rpg_class' => $data[1],
			'added_health' => $data[2],
			'added_damage' => $data[3],
			'cost' => $data[4],
			'marketable' => $data[5]
		]);
	}
}
