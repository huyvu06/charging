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
        Schema::create('tram_sac', function (Blueprint $table) {
            $table->id('id_tramsac'); 
            $table->string('phone'); // Số điện thoại, có thể để trống  
            $table->string('name');
            $table->string('email')->unique(); 
            $table->string('name_tramsac'); 
            $table->text('content'); 
            $table->string('map')->nullable(); 
            $table->string('address'); 
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('id_doitac')->nullable();
            $table->boolean('status')->default(0); 
            $table->timestamps(); 

            // Thêm khóa ngoại nếu có bảng đối tác và người dùng
            $table->foreign('id_doitac')->references('id_doitac')->on('network_system')->onDelete('set null');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tram_sac');
        Schema::table('tram_sac', function (Blueprint $table) {
            // Khôi phục kiểu dữ liệu cũ của cột `map`
            $table->decimal('map', 10, 6)->change();
        });
    }
};
