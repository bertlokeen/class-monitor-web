<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('first_name')->after('id')->nullable();
            $table->string('middle_name')->after('first_name')->nullable();
            $table->string('last_name')->after('middle_name')->nullable();
            $table->string('address')->after('remember_token')->nullable();
            $table->string('father_name')->after('address')->nullable();
            $table->string('mother_name')->after('father_name')->nullable();
            $table->date('date_of_birth')->after('mother_name')->nullable();
            $table->string('place_of_birth')->after('date_of_birth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn(['address', 'father_name', 'mother_name', 'date_of_birth', 'place_of_birth']);
        });
    }
}
