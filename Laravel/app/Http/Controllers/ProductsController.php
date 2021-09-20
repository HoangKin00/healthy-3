<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function product( Product $pro)
    {
        $product = Product::search()->paginate(12);
        $category = Category::all();
        return view('product', compact('product','category','pro'));
    }
    public function product_detail(Product $pro, $slug, Rating $rating)
    {
        $auth = Auth::guard('customer')->user();
        $pro_detail = $pro->category_id;
        $start = Rating::where('product_id',$pro->id)->avg('number_start');
        $star = Rating::join('customer', 'rating.customer_id', '=', 'customer.id')->where('product_id',$pro->id)->get();
        $count_rating = Rating::join('customer', 'rating.customer_id', '=', 'customer.id')->where('product_id',$pro->id)->count();
        $product = Product::where('category_id','=',$pro_detail)->limit(5)->get();
        $images = $pro->images()->get();
        return view('product_detail', compact('pro','product','images','start','count_rating','star'));
    }

    public function category(Category $cat, Product $pro)
    {
        $category = Category::all();
        $product = $cat->product()->paginate(6);
        return view('product', compact('cat','product','category'));
    }
    public function rating(Request $request)
    {
       $data = $request->only('product_id','customer_id','number_start','content');
       $rated = Rating::where( $request->only('product_id','customer_id'))->first();
       if($rated){
        $rated->where('id',$rated->id)->update(['number_start'=>$request->number_start]);
       }else{
        Rating::create($data);
       }

       return redirect()->back();
    }
}
