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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->text('title');
            $table->text('description');
            $table->mediumText('content');
            $table->string('url', 255)->unique();
            $table->dateTime('published_at');
            $table->string('author')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('source')->nullable();
            $table->string('provider');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
