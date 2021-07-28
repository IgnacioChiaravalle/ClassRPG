<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeaponSeeder extends Seeder
{
	public function run() {
		$this->insertIntoTable([
			'Espada de Madera',
			'Warrior',
			'1',
			'5',
			'true'
		]);
		$this->insertIntoTable([
			'Dardos Simples',
			'Rogue',
			'1',
			'2',
			'true'
		]);
		$this->insertIntoTable([
			'Galaxy Sword',
			'Rogue',
			'1000000',
			'0',
			'false'
		]);
	}

	private function insertIntoTable(array $data) {
		DB::table('weapons')->insert([
			'name' => $data[0],
			'rpg_class' => $data[1],
			'added_damage' => $data[2],
			'cost' => $data[3],
			'marketable' => $data[4]
		]);
	}
}
