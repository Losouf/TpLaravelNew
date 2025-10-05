<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\Encryptable;

class Dish extends Model
{
    use HasFactory, Encryptable;

    protected $fillable = ['user_id','name','image_path','description','recipe'];
    protected array $encryptable = ['recipe'];

    public function creator() { return $this->belongsTo(User::class, 'user_id'); }
    public function favoredBy() { return $this->belongsToMany(User::class, 'dish_user'); }
}
