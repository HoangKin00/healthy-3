<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeCartController extends Controller
{
    public function add(Product $product, $quantity = 1,Request $request)
    {
        $auth = Auth::guard('customer')->user();
        $quantity = $request->quantity ? $request->quantity : 1;

        $cart_item = Cart::where(['product_id' => $product->id, 'customer_id' => $auth->id])->first();
        if ($cart_item) {
            $cart_item->quantity += $quantity;
            $newquantity = $cart_item->quantity;
            $cart_item->update(['quantity' => $newquantity]);
        } else {
            Cart::create([
                'product_id' => $product->id,
                'price'       => $product->sale_price > 0 ? $product->sale_price : $product->price,
                'quantity'   => $quantity,
                'customer_id' => $auth->id
            ]);
        }
        return redirect()->route('cart.view')->with('success', 'Bạn đã thêm Sản phẩm vào giỏ hàng thành công');
    }

    public function remove($id)
    {
        $cart_item = Cart::find($id);
        if ($cart_item) {
            $cart_item->delete();
        }

        return redirect()->route('cart.view')->with('success', 'Bạn đã xóa Sản phẩm trong giỏ hàng thành công');
    }

    public function update($id)
    {

        $cart_item = Cart::find($id);
        $quantity = request('quantity', 1);
        if ($cart_item) {
            $cart_item->update(['quantity' => $quantity]);
        }
        return redirect()->route('cart.view')->with('success', 'Bạn đã cập nhật Sản phẩm trong giỏ hàng thành công');
    }

    public function updateAll($id)
    {
        $ids = request('id', []);
        $qtts = request('qtt', []);
    }

    public function clear()
    {
        $auth = Auth::guard('customer')->user();
        Cart::where('customer_id', $auth->id)->delete();

        return redirect()->route('cart.view')->with('success', 'Bạn đã xóa hết Sản phẩm trong giỏ hàng thành công');
    }

    public function view()
    {
        $auth = Auth::guard('customer')->user();
        $items = Cart::where('customer_id', $auth->id)->get();
        $total = Cart::where('customer_id', $auth->id)->select(DB::raw('sum(price*quantity) as total'))->first();
        $quantitys = Cart::where('customer_id', $auth->id)->sum('quantity');
        return view('cart-view', compact('items','total','quantitys'));
    }
}
