<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('stream_url');
            $table->string('stream_type')->default('live');
            $table->string('source');
            $table->string('logo')->nullable();
            $table->string('epg_channel_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


    }

    public function down(): void
    {

        Schema::dropIfExists('channels');
    }
};