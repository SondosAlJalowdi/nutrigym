<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceProvider;
use App\Models\User;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'provider_id',
        'stars',
        'comment',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function serviceProvider() {
        return $this->belongsTo(ServiceProvider::class);
    }

}
