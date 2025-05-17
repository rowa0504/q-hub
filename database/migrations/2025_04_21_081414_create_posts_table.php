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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description');
            $table->longText('image')->nullable();
            $table->string('location')->nullable()->comment('food/travel');
            $table->decimal('latitude', 10, 7)->nullable()->comment('food/travel');
            $table->decimal('longitude', 10, 7)->nullable()->comment('food/travel');
            $table->string('departure')->nullable()->comment('trans');
            $table->string('destination')->nullable()->comment('trans');
            $table->integer('fee')->nullable()->comment('trans');
            $table->integer('max')->nullable()->comment('event/item');
            $table->datetime('startdatetime')->nullable()->comment('event');
            $table->datetime('enddatetime')->nullable()->comment('event');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('trans_category_id')->nullable()->comment('trans');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('best_answer_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('trans_category_id')->references('id')->on('trans_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
