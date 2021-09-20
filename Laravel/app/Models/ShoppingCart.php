<?php
namespace App\Models;

use Illuminate\Support\Facades\Auth;

class ShoppingCart
{
  public function Add($product,$quantity = 1)
  {
    $auth = Auth::guard('customer')->user();
    $cart_item = Cart::where(['product_id' => $product->id, 'customer_id'=>$auth->id])->first();
    if($cart_item){
        $cart_item->increment('quantity');
    }else{
        Cart::create([
            'product_id' => $product->id,
            'price'       =>$product->sale_price > 0 ? $product->sale_price : $product->price ,
            'quantity'   => $quantity,
            'customer_id' =>$auth->id
        ]);
    }
  }

  public function remove($id)
  {
      $cart_item = Cart::find($id);
      if($cart_item){
          $cart_item->delete();
      }
  }
public function update($id)
{
    $cart_item = Cart::find($id);
    $quantity = request('quantity',1);
    if($cart_item){
        $cart_item->update(['quantity'=>$quantity]);
    }
}
public function clear()
{
    $auth = Auth::guard('customer')->user();
   Cart::where('customer_id', $auth->id)->delete();
}
public function view()
{
    $auth = Auth::guard('customer')->user();
    $items = Cart::where('customer_id',$auth->id)->get();
    return view('cart-view',compact('items'));
}

}


?>
