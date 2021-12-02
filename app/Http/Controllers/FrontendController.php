<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['galleries'])->latest()->get();
        return view('pages.frontend.index', compact('products'));
    }
    
    public function details(Request $request, $slug)
    {
        $products = Product::with(['galleries'])->where('slug',$slug)->firstOrFail();
        $recommendations = Product::with(['galleries'])->inRandomOrder()->limit(4)->get();
        return view('pages.frontend.details',compact('products','recommendations'));
    }

    public function cartAdd(Request $request, $id)
    {
        Cart::create([
            'users_id' => Auth::user()->id,
            'products_id' => $id
        ]);
        return redirect('cart');
    }
        
    public function cart(Request $request)
    {
        return view('pages.frontend.cart');
    }

    public function success(Request $request)
    {
        return view('pages.frontend.success');
    }
}
