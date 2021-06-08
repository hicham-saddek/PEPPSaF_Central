<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean("value");
            $table->string("hostname");
            $table->string("over");
            $table->integer("namespace");
            $table->integer("identifier");
            $table->string("arrived_at");
            $table->string("sent_at");
            $table->string("received_at");
            $table->boolean("seen")->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data');
    }
}
