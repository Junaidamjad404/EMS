<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Image;
use App\Models\Video;
use App\Models\Category;
use App\Enums\EventStatus;
use App\Models\TicketType;
use App\Models\TicketPurchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable=['title','organizer_id','category_id','date','location','description','status'];
    
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    protected $casts = [
        'date' => 'datetime', // Automatically cast the date field to a Carbon instance
    ];
    
     public function ticketTypes()
    {
        return $this->belongsToMany(TicketType::class, 'event_ticket_type')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function date(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::parse($value), // Format for input[type="datetime-local"]
            set: fn ($value) => Carbon::parse($value)->format('Y-m-d H:i:s'), // Ensure it's saved in correct format
        );
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function organizer(){
        return $this->belongsTo(User::class,'organizer_id');
    }
     public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
    public function ticketPurchases()
    {
        return $this->hasMany(TicketPurchase::class);
    }
}
