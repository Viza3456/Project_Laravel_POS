<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\PayOrder;
use App\Models\Order;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderProductController extends Controller
{
    public function index(){
        return view('orderproduct',['select' => $this->select()]);
    }
    public function select(){
        return Category::select('id','name')->get();
    }
    public function orderpro(Request $request){
        $this->validate($request,[
            'discount' => 'required|numeric|min:0',
            'totally' => 'required|numeric|min:1',
            'total' => 'required|numeric|min:1|gte:totally',
            'cashin' => 'required|gte:totally',
            'cashout' => 'required|gte:0',
        ]);
        $order = PayOrder::create([
            'discount' => $request->discount,
            'total_pay' => $request->totally,
            'cash_in' => $request->cashin,
            'cash_out' => $request->cashout
        ]);
        $data = array();
        foreach($request->order as $d){
            $nest = array();
            $nest['product_id'] = $d['id'];
            $nest['pay_order_id'] = $order->id;
            $nest['user'] = auth()->user()->id;
            $nest['name'] = $d['name'];
            $nest['price'] = $d['price'];
            $nest['qty'] = $d['qty'];
            $nest['datetime'] = now();
            $data[] = $nest;
        }
        $post = $order->product()->sync($data);
        return $post;
    }
}
