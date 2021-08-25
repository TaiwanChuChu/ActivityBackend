<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_applies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('activity_id')->comment('活動ID');
            $table->bigInteger('CreateID')->comment('建立者ID');
            $table->bigInteger('UpdateID')->nullable()->comment('異動者ID');
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
        Schema::dropIfExists('activity_applies');
    }
}
