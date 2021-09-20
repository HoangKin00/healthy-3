<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'category';
    protected $datas = ['deleted_at'];
    protected $fillable = ['name', 'status'];

    //Join 1-n
    public function product()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    //thêm localScope
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
