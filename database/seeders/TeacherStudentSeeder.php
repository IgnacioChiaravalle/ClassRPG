<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherStudentSeeder extends Seeder {
	public function run() {
		$this->insertIntoTable(['Admin Teacher', 'Student 1', 'Es un muchacho muy trabajador.']);
		$this->insertIntoTable(['Admin Teacher', 'Student 2', 'Estudia todos los días, pero le cuesta concentrarse.']);
		$this->insertIntoTable(['Admin Teacher', 'Student 3', null]);
		$this->insertIntoTable(['Teacher 2', 'Student 3', null]);
		$this->insertIntoTable(['Teacher 3', 'Student 3', null]);
		$this->insertIntoTable(['Teacher 4', 'Student 3', null]);
		$this->insertIntoTable(['Teacher 5', 'Student 3', null]);
	}

	private function insertIntoTable(array $data) {
		DB::table('teacher_students')->insert([
			'teacher_name' => $data[0],
			'student_name' => $data[1],
			'notes_on_student' => $data[2]
		]);
	}
}
