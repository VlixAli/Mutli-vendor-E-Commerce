<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
      'cookie_id' , 'user_id' , 'product_id' , 'quantity' , 'options'
    ];

    protected static function booted()
    {
        static::observe(CartObserver::class);
    }

    public function scopeCookieId(Builder $builder, $cookieId)
    {
        $builder->where('cookie_id', '=', $cookieId);
    }

    public function user()
    {
        return $this->belongsTo(User::class)
            ->withDefault([
                'name' => 'anonymous'
            ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
