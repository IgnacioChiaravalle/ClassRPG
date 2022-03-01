<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MissionSeeder extends Seeder {
	public function run() {
		$this->insertIntoTable([
			'Miembro del Palacio Real',
			'3',
			'El Palacio Real tiene reglas estrictas para admitir nuevos miembros. Si querés ser parte de él, deberás demostrar tu dedicación absoluta estudiando un mínimo de 4 horas diarias.',
			'20',
			'1 día sin estudio',
			'200',
			'140',
			Carbon::parse('21-12-2021'),
			Carbon::parse('25-06-2028'),
			'30',
			'Una espada nueva',
			false
		]);

		$this->insertIntoTable([
			'Infiltrar el Castillo',
			'3',
			'Tendrás que derrotar a los sabios y poderosos miembros de la Guardia Real, que han sido corrompidos por un hechizo del Señor Oscuro. No te será fácil. Deberás contestar bien por lo menos 8 de las 10 preguntas que te harán.',
			'10',
			'1 pregunta mal respondida',
			'20',
			'20',
			Carbon::parse('01-12-2021'),
			null,
			'50',
			null,
			true
		]);

		$this->insertIntoTable([
			'Amigo de la Corona',
			'3',
			'La Reina tiene una misión especial para vos. Quiere que diseñes un pasadizo secreto desde sus aposentos hacia su búnker de seguridad, ¡pero cuidado! Las paredes del viejo Palacio son delgadas y vas a necesitar hacer varios cálculos para asegurarte de que no colapsen. Terminá tu tarea de matemática para demostrarle a la Reina que estás listo para esto.',
			'15',
			'1 día sin hacer la tarea',
			'15',
			'10',
			Carbon::parse('29-09-1998'),
			null,
			'5',
			null,
			false
		]);

		$this->insertIntoTable([
			'Dragón del Valle',
			'4',
			'¡El Dragón del Valle ha derrotado a las defensas de la Ciudadela, y depende de vos detenerlo antes de que destruya todo! El Viejo Marcus dice conocer un conjuro que podría detener al dragón, pero requerirá que recolectes rápido algunos ingredientes. Contestá bien las preguntas para encontrar los materiales; contestalas mal y el dragón seguirá avanzando. ¡El destino del Reino está en tus manos!',
			'10',
			'1 pregunta mal respondida',
			'50',
			'50',
			Carbon::parse('29-09-2010'),
			null,
			'45',
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
