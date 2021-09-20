<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    public function index()
    {
        // $data = Admins::all();
        $data1 = Admins::search()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        return view('admin.admin.index', compact('data1','orderByOptions'));
    }
    public function create()
    {
        return view('admin.admin.create');
    }
    public function add(Request $request)
    {
        //Validate dữ liệu
        $rules = [
            'name' => 'required|unique:admin',
            'email' => 'required|email|unique:admin',
            'phone' => 'required|numeric',
            'password' => 'required|size:8',
        ];

        $mag = [
            'name.required' => 'Tên người quản trị viên không được để trống',
            'name.unique' => 'Tên người quản trị <b>'.$request->name.'</b> đã tồn tại trong CSDL',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email <b>'.$request->email.'</b> đã tồn tại trong CSDL',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.numeric' => 'Số điện thoại không được dùng ký tự',
            // 'phone.size' => 'Số điện thoại bắt buộc phải 10 ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.size' => 'Mật khẩu bắt buộc phải 8 ký tự',
        ];
        $request->validate($rules, $mag);

        //Lấy dữ liệu
        // $form_data = $request->only('name', 'email', 'phone', 'password');
        //Lưu vào CSDL

        $added = Admins::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        if ($added) { //chưa vào đc đây đâu
            return redirect()->route('admin.index')->with('success', 'Thêm mới tài khoản thành công!');;
        } else {
            return  redirect()->back();
        }
    }

    public function destroy(Admins $adm)
    {
        $adm->delete();
        return redirect()->route('admin.index')->with('success', 'Xóa tài khoản thành công!');
    }
    public function edit(Admins $adm)
    {
        return view('admin.admin.edit', compact('adm'));
    }
    public function update($adm,Request $request)
    {
        //Validate dữ liệu
        $rules = [
            'name' => 'required|unique:admin,name,'.$adm,
            'email' => 'required|email|unique:admin,email,'.$adm,
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|size:8',
        ];

        $mag = [
            'name.required' => 'Tên người quản trị viên không được để trống',
            'name.unique' => 'Tên người quản trị <b>'.$request->name.'</b> đã tồn tại trong CSDL',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email <b>'.$request->email.'</b> đã tồn tại trong CSDL',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.numeric' => 'Số điện thoại không được dùng ký tự',
            'phone.digits' => 'Số điện thoại bắt buộc phải 10 ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.size' => 'Mật khẩu bắt buộc phải 8 ký tự',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        $form_data = Admins::find($adm);
        // dd($cat);
        $form_data ->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        //Lưu vào CSDL

        if( $form_data){ //chưa vào đc đây đâu
            return redirect()->route('admin.index')->with('success', 'Cậ nhật tài khoản thành công!');;
        }else{
            return  redirect()-> back();
        }
    }
}
