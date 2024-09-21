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
            $table->unsignedBigInteger('car_id');
            $table->timestamps();

          
            $table->foreign('tram_sac_id')->references('id_tramsac')->on('tram_sac')->onDelete('cascade');
            $table->foreign('car_id')->references('id_car')->on('car')->onDelete('cascade'); // Sửa từ 'car' thành 'cars'
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

