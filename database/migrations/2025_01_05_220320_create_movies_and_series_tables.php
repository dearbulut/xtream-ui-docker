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
        Schema::create("movies", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("stream_url");
            $table->string("logo")->nullable();
            $table->foreignId("category_id")->nullable()->constrained()->onDelete("set null");
            $table->string("stream_type")->default("movie");
            $table->boolean("is_active")->default(true);
            $table->text("description")->nullable();
            $table->string("duration")->nullable();
            $table->string("release_date")->nullable();
            $table->string("director")->nullable();
            $table->string("cast")->nullable();
            $table->string("genre")->nullable();
            $table->string("rating")->nullable();
            $table->string("poster")->nullable();
            $table->string("backdrop")->nullable();
            $table->string("trailer_url")->nullable();
            $table->json("subtitles")->nullable();
            $table->json("audio_tracks")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("series", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("logo")->nullable();
            $table->foreignId("category_id")->nullable()->constrained()->onDelete("set null");
            $table->string("stream_type")->default("series");
            $table->boolean("is_active")->default(true);
            $table->text("description")->nullable();
            $table->string("release_date")->nullable();
            $table->string("director")->nullable();
            $table->string("cast")->nullable();
            $table->string("genre")->nullable();
            $table->string("rating")->nullable();
            $table->string("poster")->nullable();
            $table->string("backdrop")->nullable();
            $table->string("trailer_url")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("seasons", function (Blueprint $table) {
            $table->id();
            $table->foreignId("series_id")->constrained()->onDelete("cascade");
            $table->string("name");
            $table->integer("season_number");
            $table->text("description")->nullable();
            $table->string("poster")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("episodes", function (Blueprint $table) {
            $table->id();
            $table->foreignId("season_id")->constrained()->onDelete("cascade");
            $table->string("name");
            $table->integer("episode_number");
            $table->string("stream_url");
            $table->text("description")->nullable();
            $table->string("duration")->nullable();
            $table->string("air_date")->nullable();
            $table->string("poster")->nullable();
            $table->json("subtitles")->nullable();
            $table->json("audio_tracks")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("episodes");
        Schema::dropIfExists("seasons");
        Schema::dropIfExists("series");
        Schema::dropIfExists("movies");
    }
};
