<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            // student (user) reference
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // course reference
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            // section reference (nullable if enrolled directly to course first, then auto-assign later)
            $table->foreignId('section_id')->nullable()->constrained()->onDelete('cascade');

            // timestamps
            $table->timestamps();

            // prevent duplicate enrollment (same student in same course)
            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
