<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user', 'writer') NOT NULL DEFAULT 'user'");
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('coins')->default(50)->after('avatar');
            $table->string('api_token', 80)->nullable()->unique()->after('coins');
        });

        Schema::table('novels', function (Blueprint $table) {
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('approved')->after('status');
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->boolean('is_premium')->default(false)->after('views');
            $table->unsignedInteger('coin_price')->default(5)->after('is_premium');
            $table->timestamp('published_at')->nullable()->after('coin_price');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('chapter_id')->constrained('comments')->cascadeOnDelete();
        });

        Schema::table('reading_histories', function (Blueprint $table) {
            $table->unsignedTinyInteger('progress_percent')->default(0)->after('chapter_id');
        });

        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('following_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['follower_id', 'following_id']);
        });

        Schema::create('chapter_unlocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'chapter_id']);
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('chapter_unlocks');
        Schema::dropIfExists('follows');

        Schema::table('reading_histories', function (Blueprint $table) {
            $table->dropColumn('progress_percent');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->dropColumn(['is_premium', 'coin_price', 'published_at']);
        });

        Schema::table('novels', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['coins', 'api_token']);
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
        }
    }
};
