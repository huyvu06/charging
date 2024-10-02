<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id('id_news');
            $table->string('title');
            $table->string('image');
            $table->text('noidung');
            $table->timestamp('date_up')->nullable();
            $table->timestamp('date_edit')->nullable();
            $table->integer('binhluan')->default(0);
            $table->integer('view')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
