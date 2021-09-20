<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeOrderController extends Controller
{
    public function checkout()
    {
        $auth = Auth::guard('customer')->user();
        $items = Cart::where('customer_id', $auth->id)->get();
        $total = Cart::where('customer_id', $auth->id)->select(DB::raw('sum(price*quantity) as total'))->first();
        $ttq = Cart::where('customer_id', $auth->id)->get();
        $tt = 0;
        foreach ($ttq as $key => $item) {
            $tt += $item['quantity'];
        }
        if ($tt > 0) {
            return view('checkout', compact('auth', 'items', 'total'));
        }
    }
    public function checkout_success()
    {
        return view('check_success');
    }
    public function error()
    {
        return view('error');
    }
    public function checkout_form(Request $request, Cart $cart, Product $product)
    {
        $check = false;
        $cus_id = Auth::guard('customer')->user()->id;
        $items = Cart::where('customer_id',  $cus_id)->get();
        $total = Cart::where('customer_id',  $cus_id)->select(DB::raw('sum(price*quantity) as total'))->first();
        $tt = $total->total;
        $order = Order::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'order_note' => $request->order_note,
            'customer_id' => $cus_id,
            'total_price' => $tt
        ]);
        $order_id = $order->id;
        if ($order) {
            $check = true;
            foreach ($items as $product_id => $item) {
                $quantity = $item['quantity'];
                $price = $item['price'];
                if (!OrderDetail::create([
                    'order_id' => $order_id,
                    'product_id' => $item->product_id,
                    'price' => $price,
                    'quantity' => $quantity
                ])) {
                    $check = false;
                    break;
                };
            }
            if ($check) {
                $cart->where('customer_id',  $cus_id)->delete();
                return redirect()->route('order.checkout_success')->with('success','Đặt hàng thành công');
            } else {
                OrderDetail::where('order_id', $order->id)->delete();
                Order::find($order->id)->delete();
                return redirect()->route('error')->with('error','Đặt hàng không thành công');
            }
        }
    }
    public function history()
    {
        $auth = Auth::guard('customer')->user();
        $orders = $auth->myOrders()->get();
        return view('history',compact('orders'));
    }
    public function orderDetail($id)
    {
        $order = Order::find($id);
        return view('detail',compact('order'));
    }
    public function delete($id)
    {
        $status = '4';
        if( $status == 0){
         Order::where('id',$id)->update(['status'=>$status]);
         return redirect()->back()->with('success','Hủy đơn hàng thành công!');
        }else{
            return redirect()->back()->with('error','Không thể hủy đơn hàng!');
        }
        
      
    }
}