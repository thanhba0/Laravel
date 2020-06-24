<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

use DB;

class Product extends Controller

{

    public function AuthLogin(){
        $admin_id=Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/admin-dashboard');
        }else{
            return Redirect::to('/login')->send();
        }

        
    }

    public function all_product(){
        $this->AuthLogin();
        $all_product=DB::table('product')
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand_product','brand_product.brand_id','=','product.brand_id')
        ->orderby('product.product_id')->get();
        return view('admin.all-product')->with('all_product',$all_product);
        // return view('admin.admin-dashboard')->with('admin.all-brand-product',$manager_product);

    }

    public function add_product(){
        $this->AuthLogin();
        $cate_product=DB::table('category_product')->orderby('category_id','desc')->get();
        $brand_product=DB::table('brand_product')->orderby('brand_id','desc')->get();
        return view('admin.add-product')->with('cate_product',$cate_product)->with('brand_product',$brand_product);

       
    }

    public function save_product(Request $request){
        $this->AuthLogin();
        $data=array();
        $data['product_name']=$request->product_name;
        $data['product_desc']=$request->product_desc;
        $data['product_content']=$request->product_content;
        $data['product_price']=$request->product_price;        
        $data['product_status']=$request->product_status;
        $data['category_id']=$request->product_category;
        $data['brand_id']=$request->product_brand;

        // echo'<pre>';
        // print_r($data);
        // echo'</pre>';

        $get_image=$request->file('product_image');
        if($get_image){
            $get_name_image=$get_image->getClientOriginalName();
            $name_image=current(explode('.',$get_name_image));
            $new_image=$name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/admin/image',$new_image);
            $data['product_image']=$new_image;
            DB::table('product')->insert($data);
            Session::put('message','Thêm sản phẩm thành công');
            return Redirect::to('/add-product');
         
        }
         
        
    }

    public function edit_product($product_id){
        $this->AuthLogin();
        $cate_product=DB::table('category_product')->orderby('category_id','desc')->get();
        $brand_product=DB::table('brand_product')->orderby('brand_id','desc')->get();
        $edit_product=DB::table('product')->where('product_id',$product_id)->get();
        return view('admin.edit-product')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);
        // return view('admin.admin-dashboard')->with('admin.all-brand-product',$manager_product);

    }

    public function update_product($product_id,Request $request){
        $this->AuthLogin();
        $data=array();
        $data['product_name']=$request->product_name;
        $data['product_desc']=$request->product_desc;
        $data['product_content']=$request->product_content;
        $data['product_price']=$request->product_price;        
        $data['product_status']=$request->product_status;
        $data['category_id']=$request->product_category;
        $data['brand_id']=$request->product_brand;

        $get_image=$request->file('product_image');
        if($get_image){
            $get_name_image=$get_image->getClientOriginalName();
            $name_image=current(explode('.',$get_name_image));
            $new_image=$name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/admin/image',$new_image);
            $data['product_image']=$new_image;
            DB::table('product')->where('product_id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công');
            return Redirect::to('/all-product');
         
        }

    }

    public function delete_product($product_id){
        $this->AuthLogin();
       
        DB::table('product')->where('product_id',$product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('/all-product');

    }
}
