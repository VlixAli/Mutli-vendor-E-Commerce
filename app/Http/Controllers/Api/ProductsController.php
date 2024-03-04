<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\StoreRequest;
use App\Http\Requests\Api\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products =  Product::filter($request->query())
            ->with('category:id,name', 'store:id,name', 'tags:id,name')
            ->paginate();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = $request->user();
        if(!$user->tokenCan('products.create')){
            return response([
                'message' => 'Not allowed'
            ], 403);
        }
        $product =  Product::create($request->validated());

        return Response::json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $user = $request->user();
        if(!$user->tokenCan('products.update')){
            return response([
                'message' => 'Not allowed'
            ], 403);
        }
        $product->update($request->validated());

        return Response::json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::guard('sanctum')->user();
        if(!$user->tokenCan('products.delete')){
            return response([
                'message' => 'Not allowed'
            ], 403);
        }
        Product::destroy($id);
        return response()->json(null, 204);
    }
}
