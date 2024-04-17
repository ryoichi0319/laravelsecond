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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // 外部キー制約
            $table->integer('table_number'); // テーブル番号
            $table->string('status')->default('pending'); // 注文の状態（デフォルトは 'pending'）
            $table->integer('total_amount'); // 合計金額を整数として保存
            $table->timestamps(); // 作成日時と更新日時の自動管理
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
