<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Channel extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        "name",
        "stream_url",
        "logo",
        "category_id",
        "stream_type",
        "is_active",
        "epg_channel_id",
    ];

    protected $casts = [
        "is_active" => "boolean",
        "metadata" => "array",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function epgPrograms()
    {
        return $this->hasMany(EpgProgram::class);
    }

    public function bouquets()
    {
        return $this->belongsToMany(Bouquet::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }
}
