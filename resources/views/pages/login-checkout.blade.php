@extends('layout')
@section('content')



<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Đăng nhập tài khoản</h2>
                    <form action="{{URL::to('/login-customer')}}" method="post">
                        {{csrf_field()}}
                        <input type="email" placeholder="Tài khoản" name="email_account" />
                        <input type="password" placeholder="Password" name="password_account"/>
                        {{-- <span>
                            <input type="checkbox" class="checkbox"> 
                            Ghi nhớ đăng nhập
                        </span> --}}
                        <button type="submit" class="btn btn-default">Đăng nhập</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng ký mới</h2>
                    <form action="{{URL::to('/add-customer')}}" method="post">
                        {{csrf_field()}}
                        <input type="text" placeholder="Họ và tên" name="customer_name" />
                        <input type="email" placeholder="Email" name="customer_email"/>
                        <input type="password" placeholder="Password" name="customer_password"/>
                        <input type="number" placeholder="Phone" name="customer_phone"/>
                        <button type="submit" class="btn btn-default">Đăng ký</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->





@endsection