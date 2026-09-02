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
        Schema::create('complaints', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tracking_code')->unique();
            $table->string('reporter_name')->nullable();
            $table->string('reporter_contact')->nullable();
            $table->boolean('is_disability_friendly')->default(false);
            $table->string('title');
            $table->text('description');
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->enum('status', ['pending', 'invalid', 'processing', 'resolved'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
