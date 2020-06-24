<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

use DB;
use Cart;

class CheckoutController extends Controller
{
    public function login_checkout(){

        $cate_product=DB::table('category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product=DB::table('brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        return view('pages.login-checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function login_customer(Request $request){
        $email=$request->email_account;
        $password=md5($request->password_account);
        $result=DB::table('customer')->where('customer_email',$email)->where('customer_password',$password)->first();

        
        // echo('<pre');
        // print_r($result);
        // echo('</pre>');
        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout');
        }else{
            
            return Redirect::to('/login-checkout');
        }
        
        
    }

    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }

    public function add_customer(Request $request){
        

        $data=array();
        $data['customer_name']=$request->customer_name;
        $data['customer_email']=$request->customer_email;
        $data['customer_password']=md5($request->customer_password);
        $data['customer_phone']=$request->customer_phone;
        $customer_id=DB::table('customer')->insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/checkout');

    }

    public function checkout(){
        $cate_product=DB::table('category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product=DB::table('brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();
        return view('pages.checkout')->with('category',$cate_product)->with('brand',$brand_product);
       
    }

    public function save_checkout_customer(Request $request){

        $data=array();
        $data['shipping_name']=$request->shipping_name;
        $data['shipping_phone']=$request->shipping_phone;
        $data['shipping_email']=$request->shipping_email;
        $data['shipping_notes']=$request->shipping_notes;
        $data['shipping_address']=$request->shipping_address;

        $shipping_id=DB::table('shipping')->insertGetId($data);
        // echo('<pre>');
        // print_r($shipping_id);
        // echo('</pre>');

        Session::put('shipping_id',$shipping_id);
              
        return Redirect::to('/payment');

    }



    public function payment(){  
        $cate_product=DB::table('category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product=DB::table('brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();

        return view('pages.payment')->with('category',$cate_product)->with('brand',$brand_product);   
    }
}
