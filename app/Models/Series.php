<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Series extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        "name",
        "logo",
        "category_id",
        "stream_type",
        "is_active",
        "description",
        "release_date",
        "director",
        "cast",
        "genre",
        "rating",
        "poster",
        "backdrop",
        "trailer_url",
    ];

    protected $casts = [
        "is_active" => "boolean",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
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
