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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('university_name')->default('University Name');
            $table->string('academic_year')->default('2025-2026');
            $table->integer('current_semester')->default(1);
            $table->enum('attendance_status', ['Open', 'Closed'])->default('Open');
            $table->timestamps();
        });

        // Insert default settings row
        DB::table('settings')->insert([
            'university_name' => 'University Name',
            'academic_year' => '2025-2026',
            'current_semester' => 1,
            'attendance_status' => 'Open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
