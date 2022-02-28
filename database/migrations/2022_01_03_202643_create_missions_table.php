<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('missions', function (Blueprint $table) {
			$table->id()->unique();
			$table->string('name');
			$table->foreignId('teacher_student_relation_id')->references('id')->on('teacher_students')->onDelete('cascade')->onUpdate('cascade');
			$table->text('description');
			$table->unsignedInteger('damage_caused');
			$table->string('damage_period');
			$table->unsignedInteger('max_health');
			$table->unsignedInteger('current_health');
			$table->date('start_date');
			$table->date('finish_date')->nullable();
			$table->unsignedInteger('coins_reward');
			$table->string('other_rewards')->nullable();
			$table->boolean('archived');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('missions');
	}
}
