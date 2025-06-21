<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'shipping_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('shipping_method')->default('standard')->after('shipping_address');
            });
        } else {
            // Nếu cột đã tồn tại, đảm bảo đúng kiểu và có default
            DB::statement("ALTER TABLE orders MODIFY shipping_method VARCHAR(255) NOT NULL DEFAULT 'standard'");
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'shipping_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('shipping_method');
            });
        }
    }
};
