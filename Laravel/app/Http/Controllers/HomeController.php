<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Advertisement;
use App\Models\Comment;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Banner::all();
        $product = Product::where('status',1)->limit(8)->get();
        $sale_product = Product::where('status',2)->orderBy('created_at','DESC')->limit(8)->get();
        $advertisement = Advertisement::all();
        $prod = Product::limit(5)->get();
        $comment = Comment::all();
        return view('welcome', compact('data','product','sale_product','advertisement','prod','comment'));
    }
    public function search(){
        if(request()->key){
            $search = Product::where('name','LIKE','%'.request()->key.'%')->paginate(12);
        };
        $data = Banner::all();
        return view ('search',compact('search','data'));
    }
}
