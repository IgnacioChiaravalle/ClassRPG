<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder {
	public function run() {
		$this->insertIntoTable([
			'Student 1',
			'Guerrero',
			'Espada de Madera',
			'Escudo de Madera',
			'Armadura de Cuero',
			'10',
			'20'
		]);
		$this->insertIntoTable([
			'Student 2',
			'Pícaro',
			null,
			null,
			null,
			'50',
			'0'
		]);
		$this->insertIntoTable([
			'Student 3',
			'Pícaro',
			null,
			null,
			null,
			'100',
			'0'
		]);
	}

	private function insertIntoTable(array $data) {
		DB::table('students')->insert([
			'name' => $data[0],
			'rpg_class' => $data[1],
			'weapon' => $data[2],
			'item' => $data[3],
			'armor' => $data[4],
			'coins' => $data[5],
			'health' => $data[6],
		]);
	}
}
