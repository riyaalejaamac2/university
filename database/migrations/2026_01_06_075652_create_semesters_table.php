<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Semester 1"
            $table->enum('group', ['A', 'B', 'None'])->default('None');
            $table->string('academic_year'); // e.g., "2025-2026"
            $table->enum('status', ['Active', 'Inactive', 'Archived'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
