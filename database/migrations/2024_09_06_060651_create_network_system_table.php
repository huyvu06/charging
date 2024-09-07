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
        Schema::create('network_system', function (Blueprint $table) {
            $table->id('id_doitac');
            $table->string('name');  
            $table->string('phone'); 
            $table->string('email');  
            $table->enum('khuvuc', ['bắc', 'trung', 'nam']); // Area options: Bắc, Trung, Nam
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('network_system');
    }
};
