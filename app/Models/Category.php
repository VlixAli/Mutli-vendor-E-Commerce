<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug'
    ];

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, fn($builder, $value) =>
            $builder->where('categories.name', 'LIKE', "%{$value}%"));

        $builder->when($filters['status'] ?? false, fn($builder, $value) =>
            $builder->where('categories.status', '=', $value));
    }

    public static function rules($id = 0)
    {
        return ['name' => ['required', 'string', 'min:3', 'max:255',
            Rule::unique('categories', 'name')->ignore($id),
            'filter:php,laravel,html'
//            new Filter(['php','laravel','html']),
        ],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'status' => 'required|in:active,archived',

        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id' , 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id' , 'id')
            ->withDefault([
                'name' => '-'
            ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id' , 'id');
    }

    //Accessors
    public function getImageURlAttribute()
    {
        if(!$this->image) {
            return asset('storage/defaultProductImage.png');
        }
        if(Str::startsWith($this->image, ['http://' , 'https://'])){
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
