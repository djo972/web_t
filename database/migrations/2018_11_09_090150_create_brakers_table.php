<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brakers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('video_file')->nullable();
            $table->string('preview')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_shareable')->default(true);

            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brakers');
    }
}
