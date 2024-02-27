<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Cart\StoreRequest;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartRepositoryImpl;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cartRepository)
    {
        return view('front.cart', [
            'cart' => $cartRepository
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, CartRepository $cartRepository)
    {
        $product = Product::findOrFail($request->validated('product_id'));
        $cartRepository->add($product, $request->validated('quantity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, CartRepository $cartRepository)
    {
        $product = Product::findOrFail($request->validated('product_id'));
        $cartRepository->update($product, $request->validated('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cartRepository,string $id)
    {
        $cartRepository->delete($id);
    }
}
