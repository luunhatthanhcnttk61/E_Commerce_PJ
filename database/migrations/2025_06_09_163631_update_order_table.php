<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_code')) {
                $table->string('order_code')->after('id');
            }
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('order_code');
            }
            if (!Schema::hasColumn('orders', 'name')) {
                $table->string('name')->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'email')) {
                $table->string('email')->after('name');
            }
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone')->after('email');
            }
            if (!Schema::hasColumn('orders', 'address')) {
                $table->string('address')->after('phone');
            }
            if (!Schema::hasColumn('orders', 'note')) {
                $table->text('note')->nullable()->after('address');
            }
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 15, 2)->after('note');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->enum('payment_method', ['cod', 'VNPAY', 'MOMO'])->default('cod')->after('total_amount');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'refunded'])->default('unpaid')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'order_status')) {
                $table->enum('order_status', ['pending', 'processing', 'shipping', 'completed', 'cancelled', 'refunded'])->default('pending')->after('payment_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_code',
                'user_id',
                'name',
                'email',
                'phone',
                'address',
                'note',
                'total_amount',
                'payment_method',
                'payment_status',
                'order_status'
            ]);
        });
    }
    
};
