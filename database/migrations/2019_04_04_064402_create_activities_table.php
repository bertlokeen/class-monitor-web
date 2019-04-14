<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('section_class_id')->nullable();
            $table->string('period')->nullable();
            $table->string('activity_name')->nullable();
            $table->string('type')->nullable();
            $table->integer('items')->nullable();
            $table->string('time')->nullable();
            $table->timestamps();

            $table->foreign('section_class_id')->references('id')->on('section_classes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
