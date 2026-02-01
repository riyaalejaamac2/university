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
        Schema::table('students', function (Blueprint $table) {
            $table->index('fullname');
            $table->index('department');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->index('course_name');
            $table->index('teacher_name');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->index('status');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['fullname']);
            $table->dropIndex(['department']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['course_name']);
            $table->dropIndex(['teacher_name']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['date']);
        });
    }
};
