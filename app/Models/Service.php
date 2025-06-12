<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ServiceProvider;
use App\Models\Category;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'provider_id',
        'category_id',
        'title',
        'description',
        'price',
        'image',
    ];
    public function serviceProvider() : BelongsTo {
        return $this->belongsTo(ServiceProvider::class, 'provider_id');
    }
    public function category() : BelongsTo {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function getImageUrlAttribute() {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

}
