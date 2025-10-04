<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceSerialPartFieldsToReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivings', function (Blueprint $table) {
            // Rename po_number to reference_number (make it optional as per UAT requirements)
            // $table->renameColumn('po_number', 'reference_number');

            // Add serial_number and part_number fields
            $table->string('serial_number')->nullable()->after('qty');
            $table->string('part_number')->nullable()->after('serial_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivings', function (Blueprint $table) {
            $table->renameColumn('reference_number', 'po_number');
            $table->dropColumn(['serial_number', 'part_number']);
        });
    }
}
