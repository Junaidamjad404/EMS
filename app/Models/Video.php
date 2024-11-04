<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['event_id', 'video_url'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
