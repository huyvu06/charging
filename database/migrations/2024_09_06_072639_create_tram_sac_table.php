<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Chạy migration để tạo bảng tram_sac.
     */
    public function up(): void
    {
        Schema::create('tram_sac', function (Blueprint $table) {
            $table->id('id_tramsac'); 
            $table->string('phone')->nullable(); 
            $table->string('name');
            $table->longText('image');
            $table->string('email'); 
            $table->string('name_tramsac'); 
            $table->text('content'); 
            $table->decimal('map_lat', 10, 7)->nullable(); 
            $table->decimal('map_lon', 10, 7)->nullable(); 
            $table->string('address'); 
            $table->string('confirmation_token', 40)->nullable();; 
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('id_doitac')->nullable();
            $table->boolean('status')->default(0); 
            $table->timestamps(); 

            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_doitac')->references('id_doitac')->on('network_system')->onDelete('set null');
        });
    }

    /**
     * Hoàn tác migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('tram_sac');
    }
};
