<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product';
    protected $datas =['deleted_at'];
    protected $fillable = ['name', 'image', 'price', 'sale_price', 'content', 'status', 'category_id'];

    public function cat()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    //Check OrderDetail

    public function hasDetail()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }
    public function hasRating()
    {
        return $this->hasMany(Rating::class, 'product_id', 'id');
    }
    //thêm localScope
    //gồm sắp xếp tìm kiếm
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
        if(request()->cat){
            $query = $query->where('category_id', request()->cat);
        }
        return $query;
    }

}
