<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Create the orders table.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Guest checkout allowed (nullable user)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Shipping details (collected on checkout page)
            $table->string('full_name');
            $table->string('address');
            $table->string('city');
            $table->string('zip_code', 20);

            // Payment
            $table->enum('payment_method', ['credit_card', 'digital_wallets'])->default('credit_card');

            // Financials
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // Order lifecycle
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
