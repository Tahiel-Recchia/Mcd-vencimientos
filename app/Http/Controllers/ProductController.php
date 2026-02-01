<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function rules(Product $product){
        $rules = $product->expirationRules;
        return view('rules', compact('rules', 'product'));
    }

    public function viewExpirationRules(Request $request, Product $product){
        $rules = $product->expirationRules;
        $category = $request->category_id;
        $expirationDate = $product->getExpirationDate();
        return view('expirationRules', compact('product', 'rules', 'expirationDate', 'category'));
    }
}
