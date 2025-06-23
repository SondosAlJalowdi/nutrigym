<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ServiceProvider;
use App\Models\User;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'service_id',
        'date',
        'time',
        'location',
    ];
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function serviceProvider(): BelongsTo {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function service()
{
    return $this->belongsTo(Service::class);
}

}
