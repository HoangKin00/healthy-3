<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
class AdvertisementController extends Controller
{
   public function index()
   {
    $data = Advertisement::search()->paginate(3);
    return view('admin.advertisement.index',compact('data'));
   }

   public function edit(Advertisement $adv)
   {
    return view('admin.advertisement.edit',compact('adv'));
   }
   public function update( Advertisement $adv,Request $request)
   {

       $rules = [
           'name' => 'required|unique:banner,name,'.$adv->id,
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

           $file_name = $adv->image;

       }

       $request->merge(['image'=>$file_name]);

       $form_data = $request->only('name', 'image', 'status');
       if($adv->update($form_data)){
           return redirect()->route('advertisement.index')->with('success','Sửa thành công');
       }
       return redirect()->back()->with('error','Sửa không thành công!');
   }


}
