<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Product $product)
    {
        return new ProductCollection($product->paginate(5));
    }

    public function store(Request $request, Product $product)
    {
        $product->create($request->all());
        return $product;
    }

    public function show(Product $product)
    {
        // produto
        // return $product;
        // produto e categorias relacionadas (padrão Eager Loading)
        // return $product->with('categories')->find($product->id);
        // mesmo metodo acima só que simplificado
        // return $product->load('categories');
        // produto e categorias direto do db
        return new ProductResource($product->load('categories'));
    }

    public function update(Request $request, $product)
    {
        $product->update($request->all());
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $product;
    }
}
