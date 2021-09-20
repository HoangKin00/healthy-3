<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
class CategoryController extends Controller
{
    public function index()
    {
        $data1 = Category::search()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        return view('admin.category.index', compact('data1','orderByOptions'));
    }

    public function create()
    {
        return view('admin.category.create');
    }
    public function add(CategoryCreateRequest $request)
    {
        //Lấy dữ liệu
        $form_data = $request->only('name', 'status');
        //Lưu vào CSDL
        $added = Category::create($form_data);

        if ($added) { //chưa vào đc đây đâu
            return redirect()->route('category.index');
        } else {
            return  redirect()->back();
        }
    }

    public function destroy(Category $cat)
    {
        $count_prod = Product::where('category_id', $cat->id)->count();
        if ($count_prod > 0) {
            return redirect()->route('category.index')->with('error', 'Không thể xóa danh mục này');
        } else {
            $cat->delete();
            return redirect()->route('category.index')->with('success', 'Xóa danh mục thành công!');
        }
    }
    public function forceDelete($id)
    {
        $cat = Category::withTrashed()->find($id);
        $cat->forceDelete();
        return redirect()->route('category.index')->with('success', 'Xóa vĩnh viễn danh mục thành công!');
    }

    public function edit(Category $cat)
    {
        // $cat = Category::find($id);
        return view('admin.category.edit', compact('cat'));
    }

    public function update(Category $cat, CategoryUpdateRequest $request)
    {
        $form_data = $request->only('name', 'status');
        if ($cat->update($form_data)) {
            return redirect()->route('category.index')->with('success', 'Sửa thành công');
        }
        return redirect()->back()->with('error', 'Sửa không thành công!');
    }

    public function trashed()
    {
        $data1 = Category::onlyTrashed()->paginate(3);
        return view('admin.category.trashed', compact('data1'));
    }
    public function restore($id)
    {
        $cat = Category::withTrashed()->find($id);
        $cat->restore();
        return redirect()->route('category.index')->with('success', 'Khôi phục thành công!');
    }

    public function clear(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $cat = Category::find($id);
            if($cat->product()->count()==0){
                $cat->delete();
                $n ++;

            }else{
                $n1 ++;

            }

        }

        return redirect()->route('category.index')->with('success','Đã xóa '.$n.' danh mục và có '.$n1.' danh mục không thể xóa');

    }

    public function retrieve(Request $request)
    {
        $ids = $request->id;
        foreach($ids as $id){
            $cat = Category::withTrashed()->find($id);
            if($cat){
                $cat->restore();

            }
        }
        return redirect()->route('category.index')->with('success','Đã Khôi Phục thành công');
    }

    public function deleteAll(Request $req)
    {
        $ids = $req->id;
        foreach ($ids as $id) {
            $pro = Category::withTrashed()->find($id);
            if ($pro) {
                $pro->forceDelete();
            }
        }

        return redirect()->route('category.index')->with('success', 'Đã xóa vĩnh viễn thàn công');
    }
}
