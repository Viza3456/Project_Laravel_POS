<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PayOrder;
class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'name',
        'price',
        'photo',
        'category'
    ];
    public function payorder(){
        return $this->belongsToMany(PayOrder::class, 'order','pay_order_id','product_id');
    }
}
