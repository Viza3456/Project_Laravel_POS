<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Intervention\Image\Facades\Image;
class ProductController extends Controller
{
    public function index(){
        return view('product',["select" => $this->cate()]);
    }
    public function cate(){
        return Category::select('id','name')->get();
    }
    public function storepro(Request $request){
        $this->validate($request , [
            'name' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'category' => 'required'
        ]);
        if($request->photo){
            $img = time().$request->name.".".explode(';',explode('/',$request->photo)[1])[0];
            Image::make($request->photo)->save(public_path('product/img/').$img);
            $post = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'photo' => $img,
                'category' => $request->category,
            ]);
        }
        return $post;
    }
    public function update(Request $request , $id){
        $this->validate($request , [
            'name' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'category' => 'required'
        ]);
        $findid = Product::find($id);
        $up  = $findid->update($request->all());
        return $up;
    }
    public function del($id){
        $item = Product::find($id);
        return $item->delete();
    }
    public function getpro(){
        $get = Product::orderBy('id','desc')->paginate(50);
        return $get;
    }
    public function searchpro(Request $request){
        $name = $request->searchname;
        $search = Product::where('name','Like','%'.$name.'%')->get();
        return $search;
    }
    public function search(Request $request){
        $name = $request->searchname;
        return Product::where('name' , 'LIKE', '%'.$name.'%')->get();
    }
}
