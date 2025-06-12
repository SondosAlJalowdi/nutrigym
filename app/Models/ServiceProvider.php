<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'about',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function services() {
        return $this->hasMany(Service::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

}
