<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_order', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_id')->unsigned()->index();
            $table->bigInteger('order_id')->unsigned()->index();
            $table->integer('qty')->unsigned();
            $table->double('unit_price')->unsigned();
            $table->double('total_amount')->unsigned();
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
        Schema::dropIfExists('asset_order');
    }
}
