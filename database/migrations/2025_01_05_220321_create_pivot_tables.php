<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bouquet_channel', function (Blueprint $table) {
            $table->foreignId('bouquet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('channel_id')->constrained()->cascadeOnDelete();
            $table->primary(['bouquet_id', 'channel_id']);
        });

        Schema::create('bouquet_playlist', function (Blueprint $table) {
            $table->foreignId('bouquet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('playlist_id')->constrained()->cascadeOnDelete();
            $table->primary(['bouquet_id', 'playlist_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bouquet_channel');
        Schema::dropIfExists('bouquet_playlist');
    }
};