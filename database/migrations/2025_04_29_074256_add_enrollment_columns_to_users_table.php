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
        Schema::table('users', function (Blueprint $table) {
            $table->date('enrollment_start')->nullable();
            $table->date('enrollment_end')->nullable();
            $table->string('graduation_status')->default(false);
        });
    }
    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'enrollment_start',
                'enrollment_end',
                'graduation_status',
            ]);
        });
    }
};       
