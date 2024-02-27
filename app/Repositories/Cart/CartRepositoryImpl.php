<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartRepositoryImpl implements CartRepository
{

    protected $items;

    /**
     * @param $items
     */
    public function __construct()
    {
        $this->items = collect([]);
    }


    public function get(): Collection
    {
        if(!$this->items->count()) {
            $this->items =  Cart::with('product')
                ->cookieId($this->getCookieId())
                ->get();
        }
        return $this->items;
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', '=', $product->id)
            ->cookieId($this->getCookieId())
            ->first();

        if(!$item) {
            return Cart::create([
                'cookie_id' => $this->getCookieId(),
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return $item->increment('quantity',$quantity);
    }

    public function update(Product $product, $quantity)
    {
        Cart::where('product_id', '=', $product->id)
            ->cookieId($this->getCookieId())
            ->update([
                'quantity' => $quantity,
            ]);
    }

    public function delete($id)
    {
        Cart::where('product_id', '=', $id)
            ->cookieId($this->getCookieId())
            ->delete();
    }

    public function empty()
    {
        Cart::cookieId($this->getCookieId())->destroy();
    }

    public function total(): float
    {
//        return (float) Cart::cookieId($this->getCookieId())
//            ->join('products', 'products.id', '=', 'carts.product_id')
//            ->selectRaw('sum(products.price * carts.quantity) as total')
//            ->value('total');
        return $this->get()->sum(fn($item) => $item->quantity * $item->product->price);
    }

    protected function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return $cookie_id;
    }
}
