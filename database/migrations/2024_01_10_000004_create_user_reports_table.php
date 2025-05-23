<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_reports', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('reason');
            $table->foreignId('reported_by')->constrained('users');
            $table->foreignId('reported_user')->constrained('users');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->string('review_action')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_reports');
    }
};