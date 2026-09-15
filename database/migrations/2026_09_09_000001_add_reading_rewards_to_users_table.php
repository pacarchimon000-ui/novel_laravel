<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('reading_points')->default(0)->after('coins');
            $table->unsignedInteger('reading_level')->default(1)->after('reading_points');
        });

        Schema::create('reading_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('points')->default(10);
            $table->unsignedInteger('coins')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'chapter_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reading_rewards');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['reading_points', 'reading_level']);
        });
    }
};