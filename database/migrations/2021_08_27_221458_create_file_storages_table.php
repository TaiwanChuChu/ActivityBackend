<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_storages', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('file_storage');
            $table->string('name', 200);
            $table->integer('size');
            $table->string('path', 500);
            $table->string('mime_type');
            $table->string('extension');
            $table->string('encode_name', 60);
            $table->string('token', 20)->nullable();
            $table->softDeletesTz();
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
        Schema::dropIfExists('file_storages');
    }
}
