<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChannelEpg extends Model
{
    use HasFactory;

    protected $table = 'channel_epg';

    protected $fillable = [
        'channel_id',
        'epg_id',
        'epg_channel_id',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function programs()
    {
        return $this->hasMany(EpgProgram::class, 'epg_id', 'epg_id')
            ->where('channel_id', $this->epg_channel_id);
    }

    public function getCurrentProgram()
    {
        return $this->programs()
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();
    }

    public function getNextProgram()
    {
        return $this->programs()
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->first();
    }

    public function getProgramsByDate($date)
    {
        return $this->programs()
            ->whereDate('start_time', $date)
            ->orderBy('start_time')
            ->get();
    }

    public function scopeByEpgId($query, $epgId)
    {
        return $query->where('epg_id', $epgId);
    }

    public function scopeByEpgChannelId($query, $epgChannelId)
    {
        return $query->where('epg_channel_id', $epgChannelId);
    }
}
