<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRPGClassesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rpg_classes', function (Blueprint $table) {
			$table->id();
			$table->string('name')->unique();
			$table->unsignedInteger('base_health');
			$table->unsignedInteger('base_damage');
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
		Schema::dropIfExists('rpg_classes');
	}
}
