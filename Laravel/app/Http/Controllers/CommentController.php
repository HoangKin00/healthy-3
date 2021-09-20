<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $data = Comment::search()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        return view('admin.comment.index', compact('data','orderByOptions'));
    }
    public function create()
    {
        return view('admin.comment.create');
    }
    public function add(Request $request)
    {
        //Validate dữ liệu
        $rules = [
            'name' => 'required|unique:user_comments',
            'content' => 'required',
            'position' => 'required',
        ];
        $mag = [
            'name.required' => 'Tên người thiết kế không được để trống',
            'name.unique' => 'Tên người thiết kế  <b>'.$request->name.'</b> đã tồn tại trong CSDL',
            'content.required' => 'Nội dung sản phẩm không được để trống',
            'position.required' => 'Tên chức vụ không được để trống',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        if ($request->has('file_upload')) {
            $file = $request->file_upload;
            $ext = $request->file_upload->extension();
            $file_name = time() . '-' . 'comment.' . $ext;
            $file_name = $file->getClientoriginalName();
            $file->move(public_path('uploads'), $file_name);
        }
        $request->merge(['image' => $file_name]);
        $form_data = $request->only('name', 'image', 'position', 'content', 'status');
        $form_data = $request->all();
        //Lưu vào CSDL
        $added = Comment::create($form_data);

        if ($added) {
            return redirect()->route('comment.index');
        } else {
            return  redirect()->back();
        }
    }


    public function destroy(Comment $com)
    {
        $com->delete();
        return redirect()->route('comment.index')->with('success', 'Xóa danh mục thành công!');
    }

    public function edit(Comment $com)
    {
        return view('admin.comment.edit', compact('com'));
    }

    public function update(Comment $com,Request $request)
    {

        //Validate dữ liệu
        $rules = [
            'name' => 'required|unique:user_comments,name,'.$com->id,
            'content' => 'required',
            'position' => 'required',
        ];
        $mag = [
            'name.required' => 'Tên người thiết kế không được để trống',
            'name.unique' => 'Tên người thiết kế  <b>'.$request->name.'</b> đã tồn tại trong CSDL',
            'content.required' => 'Nội dung sản phẩm không được để trống',
            'position.required' => 'Tên chức vụ không được để trống',
        ];
        $request->validate($rules, $mag);
        if($request->has('file_upload')){
            $file = $request->file_upload;
            $ext = $request->file_upload->extension();
            $file_name = time().'-'.'product.'.$ext;
            $file_name = time().$file->getClientoriginalName();
            $file->move(public_path('uploads'),$file_name);
        }
        else {

            $file_name = $com->image;

        }

        $request->merge(['image'=>$file_name]);

        $form_data = $request->only('name','image','price','sale_price','content','status','category_id');
        if($com->update($form_data)){
            return redirect()->route('comment.index')->with('success','Sửa thành công');
        }
        return redirect()->back()->with('error','Sửa không thành công!');
    }

    public function clear(Request $req)
    {
        $ids = $req->id;
        foreach($ids as $id){
            $com = Comment::find($id);
            if($com){
                $com->delete();


            }

        }

        return redirect()->route('comment.index')->with('success','Đã xóa thành công');

    }
}
