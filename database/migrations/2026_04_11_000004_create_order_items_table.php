<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Create the order_items table.
     * Each row is one product line inside an order.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();

            // Snapshot of product details at time of purchase
            $table->string('product_name');
            $table->decimal('product_price', 8, 2);

            // Lens details if frame+lenses was selected
            $table->string('lens_type')->nullable();
            $table->string('lens_material')->nullable();
            $table->decimal('lens_price', 8, 2)->default(0);

            $table->enum('purchase_type', ['frame_only', 'frame_lens'])->default('frame_only');

            // Link to the prescription used (if any)
            $table->foreignId('prescription_id')->nullable()->constrained('prescriptions')->nullOnDelete();

            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('line_total', 10, 2)->default(0); // (product_price + lens_price) * quantity

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
