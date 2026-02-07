<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
  
    public function viewExpirationRules(Request $request, Product $product){
        $rules = $product->expirationRules;
        $category = Category::find($request->category_id);
        $expirationDate = $product->getExpirationDate();
        return view('expirationRules', compact('product', 'rules', 'expirationDate', 'category'));
    }
}
