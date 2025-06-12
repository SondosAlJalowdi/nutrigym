<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'service_id',
        'status',
        'start_date',
        'end_date',
        'details',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function serviceProvider() {
        return $this->belongsTo(ServiceProvider::class);
    }
}
