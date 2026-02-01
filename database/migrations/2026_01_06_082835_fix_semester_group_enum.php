<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('semesters', function (Blueprint $table) {
            // Change group to string to allow 'None' and future flexibility, 
            // and avoid SQLite enum check constraint issues during schema modification.
            $table->string('group')->default('None')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->enum('group', ['A', 'B'])->default('A')->change();
        });
    }
};
