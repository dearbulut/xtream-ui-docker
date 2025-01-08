<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Bouquet extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        "name",
        "description",
        "type",
        "is_active",
        "sort_order",
    ];

    protected $casts = [
        "is_active" => "boolean",
        "sort_order" => "integer",
    ];

    public function channels()
    {
        return $this->belongsToMany(Channel::class);
    }

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }

    public function series()
    {
        return $this->belongsToMany(Series::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }
}
