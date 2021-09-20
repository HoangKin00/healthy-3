<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeCustomerController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('register');
    }
    public function check_login(Request $request)
    {
          //Validate dữ liệu
          $rules = [
            'email' => 'required|email|exists:customer',
            'password' => 'required|size:6',
        ];

        $mag = [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email không tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.size' => 'Mật khẩu bắt buộc phải 6 ký tự',
        ];
        $request->validate($rules, $mag);
        if(Auth::guard('customer')->attempt($request->only('email','password'),$request->has('remember'))){
            return redirect()->route('welcome')->with('success','Đăng nhập thành công');
        }else {
            return redirect()->back()->with('error','Email hoặc mật khẩu không hợp lệ');
        }
    }
    public function check_register(Request $request)
    {
         //Validate dữ liệu
         $rules = [
            'name' => 'required|unique:customer',
            'email' => 'required|email|unique:customer',
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|size:6',
            'confirm_password' => 'required|same:password',
            'address' => 'required',
            'birthday' => 'required|date_format:Y-m-d',
        ];

        $mag = [
            'name.required' => 'Tên người dùng không được để trống',
            'name.unique' => 'Tên người dùng <b>' . $request->name . '</b>  đã tồn tại trong CSDL',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.numeric' => 'Số điện thoại không được dùng ký tự',
            'phone.digits' => 'Số điện thoại bắt buộc phải 10 số',
            'password.required' => 'Mật khẩu không được để trống',
            'password.size' => 'Mật khẩu bắt buộc phải 6 ký tự',
            'confirm_password.required' => 'Mật khẩu không được để trống',
            'confirm_password.same' => 'Mật khẩu không khớp',
            'address.required' => 'Địa chỉ không được để trống',
            'birthday.required' => 'Ngày sinh không được để trống',
            'birthday.date_format' => 'Ngày sinh phải đúng định dạng, VD: 1999-08-07',
        ];
        $request->validate($rules, $mag);
        $data = $request->only('name', 'email', 'phone', 'password', 'address', 'birthday', 'gender');
        $password = bcrypt($request->password);
        $data['password'] = $password;
        if(Customer::create($data)){
            return redirect()->route('home.login')->with('success','Đăng kí thành công');
        }
        return redirect()->back()->with('error','Đã xảy ra lỗi, Vui lòng đăng kí lại');
    }
    public function logout()
    {
        Auth::guard('customer')->logout();
         return redirect()->route('home.login');
    }
}
