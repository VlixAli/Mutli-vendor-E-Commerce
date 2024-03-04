<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'store_id',
        'description',
        'image',
        'price',
        'compare_price',
        'status'
    ];

    protected $hidden = [
      'created_at' , 'updated_at' , 'deleted_at', 'image'
    ];

    protected $appends = [
      'image_url',
    ];

    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope);

        static::creating(fn(Product $product) => $product->slug = Str::slug($product->name));
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], fn($builder, $value) => $builder->where('status', $value));
        $builder->when($options['store_id'], fn($builder, $value) => $builder->where('store_id', $value));
        $builder->when($options['category_id'], fn($builder, $value) => $builder->where('category_id', $value));
        $builder->when($options['tag_id'], fn($builder, $value) => $builder->whereExist(function ($query) use ($value) {
            $query->select(1)
                ->from('product_tag')
                ->whereRaw('product_id = products.id')
                ->where('tags_id', $value);
        }));

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

    //Accessors
    public function getImageURlAttribute()
    {
        if (!$this->image) {
            return asset('storage/defaultProductImage.png');
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return null;
        }
        return number_format(100 - (100 * $this->price / $this->compare_price));
    }
}
