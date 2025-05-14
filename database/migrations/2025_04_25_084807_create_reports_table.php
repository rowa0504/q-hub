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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 通報したユーザー
            $table->morphs('reportable'); // reportable_id + reportable_type のセットを作成
            $table->string('status', 50)->default('pending');
            $table->text('message')->nullable(); // 通報の理由や説明
            $table->boolean('active')->default(true); // 現在有効な通報かどうか
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
