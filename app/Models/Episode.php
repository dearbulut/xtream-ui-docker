<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Episode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "season_id",
        "name",
        "episode_number",
        "stream_url",
        "description",
        "duration",
        "air_date",
        "poster",
        "subtitles",
        "audio_tracks",
    ];

    protected $casts = [
        "episode_number" => "integer",
        "air_date" => "datetime",
        "subtitles" => "array",
        "audio_tracks" => "array",
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function series()
    {
        return $this->hasOneThrough(Series::class, Season::class);
    }
}
