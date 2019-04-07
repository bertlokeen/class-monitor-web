<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('section_class_id')->nullable();
            $table->unsignedInteger('student_id')->nullable();
            $table->string('period')->nullable();
            $table->string('status')->nullable();
            $table->string('note')->nullable();
            $table->date('conducted_at')->nullable();
            $table->timestamps();

            $table->foreign('section_class_id')->references('id')->on('section_classes')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
