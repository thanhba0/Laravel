<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

use DB;

class CategoryProductController extends Controller
{

    public function AuthLogin(){
        $admin_id=Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/admin-dashboard');
        }else{
            return Redirect::to('/login')->send();
        }

        
    }

   








    //admin

    public function all_category_product(){
        $this->AuthLogin();
        $all_category_product=DB::table('category_product')->get();
        return view('admin.all-category-product')->with('all_category_product',$all_category_product);
        // return view('admin.admin-dashboard')->with('admin.all-category-product',$manager_category_product);

    }

    public function add_category_product(){
        $this->AuthLogin();
        return view('admin.add-category-product');
    }

    public function save_category_product(Request $request){
        $this->AuthLogin();
        $data=array();
        $data['category_name']=$request->category_product_name;
        $data['category_desc']=$request->category_product_desc;
        $data['category_status']=$request->category_product_status;

        DB::table('category_product')->insert($data);
        Session::put('message','Thêm danh mục sản phẩm thành công');
        return Redirect::to('/add-category-product'); 
        
    }

    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $edit_category_product=DB::table('category_product')->where('category_id',$category_product_id)->get();
        return view('admin.edit-category-product')->with('edit_category_product',$edit_category_product);
        // return view('admin.admin-dashboard')->with('admin.all-category-product',$manager_category_product);

    }

    public function update_category_product($category_product_id,Request $request){
        $this->AuthLogin();
        $data=array();
        $data['category_name']=$request->category_product_name;
        $data['category_desc']=$request->category_product_desc;
        $data['category_status']=$request->category_product_status;
        DB::table('category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật danh mục thành công');
        return Redirect::to('/all-category-product');

    }

    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        $all_product=DB::table('product')->where('category_id',$category_product_id)->count();
        
        // echo '<pre>';
        // print_r($all_product);
        // echo '<pre>';
        if($all_product>0){
            Session::put('message','Không thể xóa vì có sản phẩm thuộc danh mục sản phẩm tồn tại');
            return Redirect::to('/all-category-product');            
        }else{
            DB::table('category_product')->where('category_id',$category_product_id)->delete();
            Session::put('message','Xóa danh mục thành công');
            return Redirect::to('/all-category-product');

        }






       
       
   

    }

   

    
    
}
