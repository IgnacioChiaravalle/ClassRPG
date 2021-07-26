<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function (Blueprint $table) {
			$table->id();
			$table->string('name')->unique();
			$table->string('rpg_class');
			$table->foreign('rpg_class')->references('name')->on('rpg_classes')->onDelete('cascade')->onUpdate('cascade');
			$table->unsignedInteger('added_health');
			$table->unsignedInteger('added_damage');
			$table->unsignedInteger('cost');
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
		Schema::dropIfExists('items');
	}
}
