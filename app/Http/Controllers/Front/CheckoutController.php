<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Checkout\StoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cartRepository)
    {
        if($cartRepository->get()->count() == 0){
            throw new InvalidOrderException('Cart is empty');
        }
        return view('front.checkout', [
            'cartRepository' => $cartRepository,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(StoreRequest $request, CartRepository $cartRepository)
    {
        $items = $cartRepository->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                ]);

                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,

                    ]);
                }

                foreach ($request->post('address') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }

            DB::commit();

//            event('order.created', $order, Auth::user());
            event(new OrderCreated($order));

        } catch (Throwable $e){
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('orders.payments.create', $order->id);
    }
}
