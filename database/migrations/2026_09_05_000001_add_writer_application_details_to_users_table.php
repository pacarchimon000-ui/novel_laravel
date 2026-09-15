<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('writer_application_email')->nullable();
            $table->text('writer_application_motivation')->nullable();
            $table->text('writer_application_experience')->nullable();
            $table->string('writer_application_genre')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'writer_application_email',
                'writer_application_motivation',
                'writer_application_experience',
                'writer_application_genre',
            ]);
        });
    }
};