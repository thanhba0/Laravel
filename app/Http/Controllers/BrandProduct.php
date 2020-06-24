<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

use DB;

class BrandProduct extends Controller
{

    public function AuthLogin(){
        $admin_id=Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/admin-dashboard');
        }else{
            return Redirect::to('/login')->send();
        }

        
    }



    //
    public function all_brand_product(){
        $this->AuthLogin();
        $all_brand_product=DB::table('brand_product')->get();
        return view('admin.all-brand-product')->with('all_brand_product',$all_brand_product);
        // return view('admin.admin-dashboard')->with('admin.all-brand-product',$manager_brand_product);

    }

    public function add_brand_product(){
        $this->AuthLogin();
        return view('admin.add-brand-product');
    }

    public function save_brand_product(Request $request){
        $this->AuthLogin();
        $data=array();
        $data['brand_name']=$request->brand_product_name;
        $data['brand_desc']=$request->brand_product_desc;
        $data['brand_status']=$request->brand_product_status;

        DB::table('brand_product')->insert($data);
        Session::put('message','Thêm Brand sản phẩm thành công');
        return Redirect::to('/add-brand-product'); 
        
    }

    public function edit_brand_product($brand_product_id){
        $this->AuthLogin();
        $edit_brand_product=DB::table('brand_product')->where('brand_id',$brand_product_id)->get();
        return view('admin.edit-brand-product')->with('edit_brand_product',$edit_brand_product);
        // return view('admin.admin-dashboard')->with('admin.all-brand-product',$manager_brand_product);

    }

    public function update_brand_product($brand_product_id,Request $request){
        $this->AuthLogin();
        $data=array();
        $data['brand_name']=$request->brand_product_name;
        $data['brand_desc']=$request->brand_product_desc;
        $data['brand_status']=$request->brand_product_status;
        DB::table('brand_product')->where('brand_id',$brand_product_id)->update($data);
        Session::put('message','Cập nhật Brand thành công');
        return Redirect::to('/all-brand-product');

    }

    public function delete_brand_product($brand_product_id){
        $this->AuthLogin();
        $all_product=DB::table('product')->where('brand_id',$brand_product_id)->count();
        
        // echo '<pre>';
        // print_r($all_product);
        // echo '<pre>';
        if($all_product>0){
            Session::put('message','Không thể xóa vì có sản phẩm thuộc brand tồn tại');
            return Redirect::to('/all-brand-product');            
        }else{
            DB::table('brand_product')->where('brand_id',$brand_product_id)->delete();
            Session::put('message','Xóa Brand thành công');
            return Redirect::to('/all-brand-product');

        }

    }
}
