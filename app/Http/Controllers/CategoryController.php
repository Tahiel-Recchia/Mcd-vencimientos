<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::with('products')->get();
        return view('category', compact('categories'));
    }

    public function getProductsFromCategory(Category $category)
    {
        $products = $category->products;
        session(['category' => $category->id]);
        return view('products', compact('category', 'products'));
    }
}
