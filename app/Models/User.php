<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Event;
use App\Mail\WelcomeMail;
use App\Models\TicketPurchase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected static function booted()
    {
        static::created(function ($user) {
        // Default to event_organizer role only if the user is not an admin
            if (!$user->is_admin) {
                $role = Role::where('name', 'event_organizer')->first();
                if ($role) {
                    $user->roles()->attach($role->id);
                }
                Mail::to($user->email)->send(new WelcomeMail(['name' => $user->name,'email' => $user->email]));
            }
        });
        static::updated(function ($user) {
            if(!$user->is_admin  && $user->active_organizer){
                $role = Role::where('name', 'event_organizer')->first();
                if ($role) {
                    $user->roles()->sync($role->id);
                }
            }else if($user->is_admin){
                $role = Role::where('name', 'admin')->first();
                if ($role) {
                    $user->roles()->sync($role->id);
                }
            }
           
        });
    }
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
        'active_organizer',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active_organizer','int'
            
        ];
    }
    public function ticketPurchases()
    {
        return $this->hasMany(TicketPurchase::class);
    }
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    
    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }
    
    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }
   
    public function hasPermission($permission)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }
}
