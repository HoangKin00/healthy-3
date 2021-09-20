<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'orderdetail';
    protected $fillable = ['product_id','order_id','price','quantity'];
    public $timestamps = false ;// loại bỏ created_at và updated_at
    public function hasPros()
    {
        return $this->hasOne(Product::class,'id', 'product_id');
    }

}
