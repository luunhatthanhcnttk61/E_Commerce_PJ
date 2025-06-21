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
        Schema::table('customers', function (Blueprint $table) {
            // Only add the new columns
            if (!Schema::hasColumn('customers', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('customers', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Remove only the columns we added
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status']);
        });
    }
};
