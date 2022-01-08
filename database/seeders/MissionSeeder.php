<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MissionSeeder extends Seeder {
	public function run() {
		$this->insertIntoTable([
			'Dragoncete',
			'3',
			'Estudiar 25 horas diarias',
			'20',
			'12 minutos',
			'120000',
			'120000',
			Carbon::parse('21-12-2021')->format('d-m-Y'),
			Carbon::parse('25-06-2028')->format('d-m-Y'),
			'69',
			'Honor',
			false
		]);

		$this->insertIntoTable([
			'Castillete',
			'3',
			'Probablemente sea invencible así que ni te gastes.',
			'69',
			'69 segundos',
			'69',
			'69',
			Carbon::parse('01-12-2021')->format('d-m-Y'),
			null,
			'420',
			null,
			true
		]);

		$this->insertIntoTable([
			'Living Life',
			'3',
			'Sobrevivir toda la vida.',
			'1',
			'1 año',
			'115',
			'23',
			Carbon::parse('29-09-1998')->format('d-m-Y'),
			null,
			'5',
			null,
			false
		]);

		$this->insertIntoTable([
			'Just a Test',
			'4',
			'Test me!',
			'15',
			'32 horas',
			'96',
			'85',
			Carbon::parse('29-09-2010')->format('d-m-Y'),
			null,
			'88',
			null,
			false
		]);
	}

	private function insertIntoTable(array $data) {
		DB::table('missions')->insert([
			'name' => $data[0],
			'teacher_student_relation_id' => $data[1],
			'description' => $data[2],
			'damage_caused' => $data[3],
			'damage_period' => $data[4],
			'max_health' => $data[5],
			'current_health' => $data[6],
			'start_date' => $data[7],
			'finish_date' => $data[8],
			'coins_reward' => $data[9],
			'other_rewards' => $data[10],
			'archived' => $data[11]
		]);
	}
}
