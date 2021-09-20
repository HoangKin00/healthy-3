<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['id','name',	'email','phone'	,'password','address','order_note','total_price','status','customer_id'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class,'order_id', 'id');
    }
    public function hasCus()
    {
        return $this->hasOne(Customer::class,'id', 'customer_id');
    }
    public function scopeSearch($query)
    {
        if (request()->key) {
            $query = $query->where('name', 'like', '%' .request()->key . '%');
        }
        if(request()->order){
            $order = explode('-', request()->order);
            $orderBy = isset($order[0]) ? $order[0] : 'id';
            $orderValue = isset($order[1]) ? $order[1] : 'DESC';
            $query = $query->orderBy($orderBy, $orderValue);
        }
        if(request()->status != '' ){
            $status = request()->status;
            $status == 2 ? request()->status = 0 : 1;
            $query = $query->where('status', request()->status);
        }
        
        return $query;
    }
}