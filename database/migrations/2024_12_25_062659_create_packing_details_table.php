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
        Schema::create('packing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packing_id')->constrained('packings');
            $table->string('section_no', 50)->nullable();
            $table->string('cut_length', 50)->nullable();
            $table->string('alloy', 50)->nullable();
            $table->string('lot_no', 50)->nullable();
            $table->string('surface', 50)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('pcs', 10)->nullable();
            $table->string('pack_date', 20)->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_details');
    }
};
