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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 50)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('contact_name', 50)->nullable();
            $table->string('contact_email', 50)->nullable();
            $table->string('country_code', 10)->default('91');
            $table->string('contact_mobile', 50)->nullable();
            $table->string('gst_no', 30)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
