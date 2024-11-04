<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value,
            set: fn ($value) => ucfirst($value),
        );
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
     public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
