<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityBasicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_basics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('activity_type_id')->comment('活動類別ID');
            $table->string('theme', 100)->comment('活動主題');
            $table->string('description', 400)->comment('活動內容');
            $table->string('place', 50)->comment('活動地點');
            $table->tinyInteger('apply_limit')->comment('報名人數上限');
            $table->datetime('apply_sdate')->comment('報名時間起');
            $table->datetime('apply_edate')->comment('報名時間訖');
            $table->boolean('apply_state')->comment('開放報名Flag');
            $table->datetime('sdate')->comment('活動時間起');
            $table->datetime('edate')->comment('活動時間訖');
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
        Schema::dropIfExists('activity_basics');
    }
}
