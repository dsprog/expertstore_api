<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(Product $product)
    {
        // produto e categorias relacionadas (padrão Lazy Loading)
        return $product->categories;
    }
}
