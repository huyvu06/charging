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
        Schema::create('tram_sac_car', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tram_sac_id');
            $table->unsignedBigInteger('charging_port_id');
            $table->timestamps();

          
            $table->foreign('tram_sac_id')->references('id_tramsac')->on('tram_sac')->onDelete('cascade');
            $table->foreign('charging_port_id')->references('id_charging_port')->on('charging_port')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tram_sac_car');
    }
};