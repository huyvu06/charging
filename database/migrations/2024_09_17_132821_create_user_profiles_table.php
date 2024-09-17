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
        Schema::create('user_profile', function (Blueprint $table) {
            $table->increments('user_profile_id');
            $table->integer('user_id');
            $table->string('name')->nullable(); 
            $table->string('phone')->nullable();;
            $table->string('address')->nullable();;
            $table->longText('image')->nullable();
            $table->string('sex')->nullable();;
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profile');
    }
};
