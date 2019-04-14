<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionClassStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_class_student', function (Blueprint $table) {
            $table->unsignedInteger('section_class_id')->nullable();
            $table->unsignedInteger('student_id')->nullable();

            $table->foreign('section_class_id')->references('id')->on('section_classes')->onDelete('cascade');

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_class_student');
    }
}
