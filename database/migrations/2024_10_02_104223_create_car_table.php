<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('car', function (Blueprint $table) {
            $table->id(); // Assuming you want an auto-incrementing primary key
            $table->string('name'); // Car name or other attributes
            $table->unsignedBigInteger('charging_port_id')->nullable();
            // $table->foreign('charging_port_id')->references('id_charging_port')->on('charging_ports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car');
    }
};
