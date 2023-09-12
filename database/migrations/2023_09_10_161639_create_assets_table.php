<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->integer('asset_type')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('name');
            $table->string('description');
            $table->date('purchase_date')->nullable();
            $table->bigInteger('current_value')->unsigned();
            $table->string('model');
            $table->string('serial_number');
            $table->string('manufacturer');
            $table->softDeletes();
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
        Schema::dropIfExists('assets');
    }
}
