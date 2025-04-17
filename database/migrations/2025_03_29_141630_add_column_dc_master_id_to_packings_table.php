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
        Schema::table('packings', function (Blueprint $table) {
            $table->foreignId('dc_master_id')->nullable()->after('customer_id')->constrained('dc_masters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packings', function (Blueprint $table) {
            $table->dropForeign(['dc_master_id']);
            $table->dropColumn('dc_master_id');
        });
    }
};
