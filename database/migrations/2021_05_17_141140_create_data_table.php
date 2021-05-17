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
            $table->integer("namespace");
            $table->integer("identifier");
            $table->timestamp("arrived_at");
            $table->timestamp("sent_at");
            $table->timestamp("received_at")->default("CURRENT_TIMESTAMP");
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
