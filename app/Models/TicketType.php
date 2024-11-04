<?php

namespace App\Models;

use App\Models\Event;
use App\Models\TicketPurchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketType extends Model
{
    use HasFactory;
   protected $fillable = [
        'name',
        'benefits',       
    ];
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_ticket_type')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
    public function ticketPurchases()
    {
        return $this->hasMany(TicketPurchase::class);
    }
}
