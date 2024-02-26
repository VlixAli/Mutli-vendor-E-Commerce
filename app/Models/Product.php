<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'category_id',
        'store_id',
        'description',
        'image',
        'price',
        'compared_price',
        'status'
    ];

    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope);
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=' , 'active');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id');
    }
}
