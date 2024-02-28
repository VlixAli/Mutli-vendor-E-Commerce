<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Cart\StoreRequest;
use App\Http\Requests\Front\Cart\UpdateRequest;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartRepositoryImpl;
use Illuminate\Http\Request;

class CartController extends Controller
{

    protected CartRepository $cartRepository;
    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('front.cart', [
            'cart' => $this->cartRepository
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $product = Product::findOrFail($request->validated('product_id'));
        $this->cartRepository->add($product, $request->validated('quantity'));

        return redirect()->route('cart.index')->with('success' , 'Product added to cart!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        $this->cartRepository->update($id, $request->validated('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cartRepository->delete($id);
    }
}
