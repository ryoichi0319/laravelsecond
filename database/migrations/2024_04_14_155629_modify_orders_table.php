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
        //
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('total_amount')->change(); // データ型を元に戻す
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_amount', 8, 2)->change(); // 合計金額のデータ型を変更
        });
    }
};
