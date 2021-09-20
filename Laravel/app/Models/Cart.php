<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = ['product_id','customer_id','price','quantity'];
    public function cart()
    {
       return $this->hasOne(Product::class, 'id','product_id');
    }

}
