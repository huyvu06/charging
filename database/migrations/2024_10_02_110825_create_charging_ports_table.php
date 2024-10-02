<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('charging_port', function (Blueprint $table) {
            $table->id('id_charging_port');
            $table->string('cong_sac');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charging_port');
    }
};

