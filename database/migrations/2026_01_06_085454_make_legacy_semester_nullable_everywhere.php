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
        // Make the old integer 'semester' column nullable in all tables 
        // because we have switched to 'semester_id' relationship.
        Schema::table('students', function (Blueprint $table) {
            $table->integer('semester')->nullable()->change();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->integer('semester')->nullable()->change();
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->integer('semester')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->integer('semester')->nullable(false)->change();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->integer('semester')->nullable(false)->change();
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->integer('semester')->nullable(false)->change();
        });
    }
};
