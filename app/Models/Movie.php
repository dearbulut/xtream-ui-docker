<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Movie extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        "name",
        "stream_url",
        "logo",
        "category_id",
        "stream_type",
        "is_active",
        "description",
        "duration",
        "release_date",
        "director",
        "cast",
        "genre",
        "rating",
        "poster",
        "backdrop",
        "trailer_url",
        "subtitles",
        "audio_tracks",
    ];

    protected $casts = [
        "is_active" => "boolean",
        "subtitles" => "array",
        "audio_tracks" => "array",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }

    public function bouquets()
    {
        return $this->belongsToMany(Bouquet::class);
    }
}
