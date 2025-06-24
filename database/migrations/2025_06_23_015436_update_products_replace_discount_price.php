<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('discount_price');
        $table->float('discount_percent')->nullable()->after('price');
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->float('discount_price')->nullable()->after('price');
        $table->dropColumn('discount_percent');
    });
}
};
