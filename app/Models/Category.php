<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function serviceProviders() {
        return $this->hasMany(ServiceProvider::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
