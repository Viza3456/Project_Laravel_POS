<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class PayOrder extends Model
{
    use HasFactory;
    protected $table = 'pay_order';
    protected $fillable = [
        'id',
        'discount',
        'total_pay',
        'cash_in',
        'cash_out'
    ];
    public function product(){
        return $this->belongsToMany(Product::class, 'order','pay_order_id','product_id');
    }
}
