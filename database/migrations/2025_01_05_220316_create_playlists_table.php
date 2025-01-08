<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_trial')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->integer('max_connections')->default(1);
            $table->integer('active_connections')->default(0);
            $table->json('allowed_ips')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


    }

    public function down(): void
    {

        Schema::dropIfExists('playlists');
    }
};