<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index(){
        return view('category');
    }
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required'
        ]);
        $post = Category::create([
            'name' => $request->name
        ]);
        return $post;
    }
    public function getcate(){
        $cate = Category::paginate(20);
        return $cate;
    }
    public function update(Request $request, $id){
        $this->validate($request,[
            'name' => 'required'
        ]);
        $data = Category::find($id);
        $up = $data->update($request->all());
        return $up;
    }
    public function del($id){
        $data = Category::find($id)->delete();
        return $data ;
    }
    public function search(Request $request){
        $name = $request->searchname;
        return Category::where('name' , 'LIKE' , '%'.$name.'%')->get();
    }
}
