<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasFactory;

    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','remember_token'];

    public function dishes() { return $this->hasMany(Dish::class); }
    public function favorites() { return $this->belongsToMany(Dish::class, 'dish_user'); }
}
