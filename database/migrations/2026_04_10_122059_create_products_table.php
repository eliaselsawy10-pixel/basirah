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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم النظارة (Classic Aviators)
            $table->text('description')->nullable(); // الوصف (Premium Titanium)
            $table->decimal('price', 8, 2); // السعر
            $table->string('image')->nullable(); // مسار الصورة في الـ public
            $table->string('category'); // (Men, Women, Kids)
            $table->integer('stock')->default(0); // الكمية المتاحة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
