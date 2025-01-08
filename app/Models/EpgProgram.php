<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EpgProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "channel_id",
        "title",
        "description",
        "start_time",
        "end_time",
        "category",
        "language",
    ];

    protected $casts = [
        "start_time" => "datetime",
        "end_time" => "datetime",
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
