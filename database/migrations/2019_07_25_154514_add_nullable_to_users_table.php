<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
        });
        DB::statement('
            ALTER TABLE users 
            MODIFY first_name varchar(191) NULL,
            MODIFY last_name varchar(191) NULL,
            MODIFY email varchar(191) NULL;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique('email');
        });
        DB::statement('
            ALTER TABLE users 
            MODIFY first_name varchar(191) NOT NULL,
            MODIFY last_name varchar(191) NOT NULL,
            MODIFY email varchar(191) NOT NULL;
        ');
    }
}
