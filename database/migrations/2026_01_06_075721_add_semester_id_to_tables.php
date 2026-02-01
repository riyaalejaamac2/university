<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Add semester_id nullable first
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('semester_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('semester_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('semester_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['semester_id']);
            $table->dropColumn('semester_id');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['semester_id']);
            $table->dropColumn('semester_id');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['semester_id']);
            $table->dropColumn('semester_id');
        });
    }
};
