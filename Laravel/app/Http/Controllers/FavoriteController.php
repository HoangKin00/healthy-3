<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class FavoriteController extends Controller
{
    public function add(Product $product)
    {
        $auth = Auth::guard('customer')->user();

        $favorite = Favorite::where(['product_id' => $product->id, 'customer_id' => $auth->id])->first();
        if( $favorite ){
            return redirect()->back()->with('error', 'Sản phẩm này đã có trong yêu thích');

        }else{
            Favorite::create([
                'product_id' => $product->id,
                'customer_id' => $auth->id
            ]);
        }

        return redirect()->back()->with('success', 'Bạn đã yêu thích sản phẩm thành công');
    }
    public function remove($id)
    {
        $favorite = Favorite::find($id);
        if ($favorite) {
            $favorite->delete();
        }

        return redirect()->route('favorite.view')->with('success', 'Bạn đã xóa Sản phẩm trong giỏ hàng thành công');
    }
    public function view()
    {
        $auth = Auth::guard('customer')->user();
        $items = Favorite::where('customer_id', $auth->id)->get();

        return view('favorite-view', compact('items'));
    }
}
