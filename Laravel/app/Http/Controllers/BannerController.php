<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $data1 = Banner::search()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        return view('admin.banner.index', compact('data1','orderByOptions'));
    }
    public function create()
    {
        return view('admin.banner.create');
    }
    public function add(Request $request)
    {
        //Validate dữ liệu
        $rules = [
            'name' => 'required|unique:banner',
        ];
        $mag = [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.unique' => 'Tên sản phẩm <b>'.$request->name.'</b>  đã tồn tại trong CSDL',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        if ($request->has('file_upload')) {
            $file = $request->file_upload;
            $ext = $request->file_upload->extension();
            $file_name = time() . '-' . 'banner.' . $ext;
            $file_name = $file->getClientoriginalName();
            $file->move(public_path('uploads'), $file_name);
        }
        $request->merge(['image' => $file_name]);

        $form_data = $request->only('name', 'image', 'status');
        $form_data = $request->all();
        //Lưu vào CSDL
        $added = Banner::create($form_data);

        if ($added) {
            return redirect()->route('Banner.index');
        } else {
            return  redirect()->back();
        }
    }
    public function destroy(Banner $ban)
    {
        $ban->delete();
        return redirect()->route('banner.index')->with('success', 'Xóa danh mục thành công!');
    }
    public function edit(Banner $ban)
    {
        return view('admin.banner.edit', compact('ban'));
    }
    public function update( Banner $ban,Request $request)
    {

        $rules = [
            'name' => 'required|unique:banner,name,'.$ban->id,
        ];
        $mag = [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.unique' => 'Tên sản phẩm <b>'.$request->name.'</b>  đã tồn tại trong CSDL',
        ];
        $request->validate($rules,$mag);

        if($request->has('file_upload')){
            $file = $request->file_upload;
            $ext = $request->file_upload->extension();
            $file_name = time().'-'.'banner.'.$ext;
            $file_name = time().$file->getClientoriginalName();
            $file->move(public_path('uploads'),$file_name);
        }
        else {

            $file_name = $ban->image;

        }

        $request->merge(['image'=>$file_name]);

        $form_data = $request->only('name', 'image', 'status');
        if($ban->update($form_data)){
            return redirect()->route('banner.index')->with('success','Sửa thành công');
        }
        return redirect()->back()->with('error','Sửa không thành công!');
    }
}
