<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Create the cart_items table.
     * Session-based carts are handled in CartController, but this table
     * persists the cart for logged-in users so it survives page refreshes.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Nullable: guest carts use session only; logged-in users are stored here
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Lens customisation chosen on select-lenses page
            $table->string('lens_type')->nullable();       // e.g. "Single Vision"
            $table->string('lens_material')->nullable();   // e.g. "Standard Plastic"
            $table->decimal('lens_price', 8, 2)->default(0);

            // Frame-only vs frame+lenses
            $table->enum('purchase_type', ['frame_only', 'frame_lens'])->default('frame_only');

            // Link back to their prescription if they entered one
            $table->foreignId('prescription_id')->nullable()->constrained('prescriptions')->nullOnDelete();

            $table->unsignedInteger('quantity')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
