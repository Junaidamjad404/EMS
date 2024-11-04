<?php

namespace App\Models;

use App\Models\User;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketPurchase extends Model
{
    use HasFactory;
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }


    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
