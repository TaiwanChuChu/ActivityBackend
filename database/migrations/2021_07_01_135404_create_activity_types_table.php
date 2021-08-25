<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_code', 10)->comment('活動類別代碼');
            $table->string('type_name', 50)->comment('活動類別名稱');
            $table->boolean('state')->comment('使用狀態');
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
        Schema::dropIfExists('activity_types');
    }
}
