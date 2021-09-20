<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
       $orders = Order::orderBy('created_at','DESC')->search()->paginate(15);
       
       return view('admin.order.index',compact('orders'));
    }

    public function detail($id)
    {
       $order = Order::find($id);
       return view('admin.order.detail', compact('order'));
    }
    public function status($id)
    {
        $status = request('status',0);
       Order::where('id',$id)->update(['status'=>$status]);
       return redirect()->back()->with('success','Cập nhập đơn hàng thành công!');
    }
}
