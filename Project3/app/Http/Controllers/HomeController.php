<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',
        [
        'user_count' => $this->userC(),
        'count_product' => $this->productC(),
        'count_category' => $this->categoryC(),
        'count_order' => $this->orderC()
        ]);
    }
    public function userC(){
        return DB::table('count_user')->get();
    }
    public function productC(){
        return DB::table('count_product')->get();
    }
    public function categoryC(){
        return DB::table('count_category')->get();
    }
    public function orderC(){
        return DB::table('count_order')->get();
    }
    public function orderSh(){
        return DB::table('order_show')->paginate(50);
    }
    public function SearchID(Request $request){
        $id = DB::table('order_show')->where('pay_order_id', '=' , $request->SOrderID)->get();
        return $id;
    }
}
