<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','price','quantity','category_id', 'provider_id'];

    protected $dateFormat = 'Y-m-d H:i:s';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function getProviderNameAttribute()
    {
        return $this->provider->name;
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
