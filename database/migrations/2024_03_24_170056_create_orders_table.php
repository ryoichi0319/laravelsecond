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
            $table->decimal('total_amount', 8, 2); // 合計金額（8桁全体で2桁まで小数点）
            $table->timestamps(); // 作成日時と更新日時の自動管理
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 8, 2); // 価格（8桁全体で2桁まで小数点）
            $table->integer('quantity'); // 数量
            $table->timestamps(); // 作成日時と更新日時の自動管理
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('orders');
    }
};

