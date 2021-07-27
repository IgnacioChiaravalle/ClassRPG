<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArmorSeeder extends Seeder
{
	public function run() {
		$this->insertIntoTable([
			'Armadura de Cuero',
			'Warrior',
			'5',
			'7'
		]);
		$this->insertIntoTable([
			'Capa Camuflada',
			'Rogue',
			'2',
			'3'
		]);
		$this->insertIntoTable([
			'Capa Armada',
			'Rogue',
			'5',
			'6'
		]);
	}

	private function insertIntoTable(array $data) {
		DB::table('armors')->insert([
			'name' => $data[0],
			'rpg_class' => $data[1],
			'added_health' => $data[2],
			'cost' => $data[3]
		]);
	}
}
