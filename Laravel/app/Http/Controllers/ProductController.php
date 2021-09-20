<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;

class ProductController extends Controller
{
    public function index()
    {
        $data1 = Product::search()->paginate(6);
        $orderByOptions = [
            'id-ASC' => 'ID tăng dần',
            'id-DESC' => 'ID giảm dần',
            'name-ASC' => 'Tên tăng dần',
            'name-DESC' => 'Tên giảm dần',
            'created_at-ASC' => 'Created at A - Z',
            'created_at-DESC' => 'Created at Z - A',
            'price-ASC' => 'Giá tăng dần',
            'price-DESC' => 'Giá giảm dần',
        ];
        $category = Category::all();
        return view('admin.product.index', compact('data1', 'orderByOptions', 'category'));
    }
    public function create()
    {
        $data = Category::all();
        return view('admin.product.create', compact('data'));
    }

    public function add(Request $request)
    {
        //Validate dữ liệu
        $rules = [
            'name' => 'required|unique:product',
            'content' => 'required',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
        ];
        $mag = [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.unique' => 'Tên sản phẩm <b>' . $request->name . '</b> đã tồn tại trong CSDL',
            'content.required' => 'Nội dung sản phẩm không được để trống',
            'price.required' => 'Giá tiền không được để trống',
            'price.numeric' => 'Giá tiền phải nhập bằng số',
            'sale_price.required' => 'Giá tiền khuyến mãi không được để trống',
            'sale_price.numeric' => 'Giá tiền khuyến mãi phải nhập bằng số',

        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        $form_data = $request->only('name', 'content', 'price', 'sale_price', 'image', 'status', 'category_id');
        if ($request->has('upload_file')) {
            $file = $request->upload_file;
            $ext = $request->upload_file->extension();
            $file_name = time() . '-' . 'product.' . $ext;
            $file_name = $file->getClientoriginalName();
            $file->move(public_path('uploads'), $file_name);
        }
        $form_data['image'] =  $file_name;

        // $form_data = $request->all();
        //Lưu vào CSDL
        $product = Product::create($form_data);
        if ($product) {
            $product_id = $product->id;
            if ($request->orther_image && count($request->orther_image)) {
                $orther_image = $request->orther_image;
                foreach ($orther_image as $key => $othImage) {
                    $ext = $othImage->extension();
                    $file_name1 = 'Product' . time() . '-' . $key . '-' . $ext;
                    if ($othImage->move(public_path('uploads'), $file_name1)) {
                        Image::create([
                            'product_id' => $product_id,
                            'image' => $file_name1
                        ]);
                    }
                }
            }
            return redirect()->route('product.index');
        } else {
            return  redirect()->back();
        }
    }

    public function destroy(Product $pro)
    {
        if ($pro->hasDetail()->count() > 0) {
            return redirect()->route('product.index')->with('error', 'Không thể xóa sản phẩm này');
        } else {
            $pro->delete();
            return redirect()->route('product.index')->with('success', 'Xóa sản phẩm thành công!');
        }
    }

    public function edit(Product $pro)
    {

        $image = Product::join('images', 'images.product_id', '=', 'product.id')->where('images.product_id', $pro->id)->get();
        $data = Category::all();
        return view('admin.product.edit', compact('pro', 'data', 'image'));
    }
    public function update(Product $pro, Request $request)
    {

        $rules = [
            'name' => 'required|unique:product,name,' . $pro->id,
            'content' => 'string|nullable',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric|between:0,'.$request->price,
        ];
        $mag = [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.unique' => 'Tên sản phẩm <b>' . $request->name . '</b> đã tồn tại trong CSDL',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.numeric' => 'Giá sản phẩm phải là dạng chữ số',
            'sale_price.required' => 'Giá khuyến mại không được để trống',
            'sale_price.numeric' => 'Giá khuyến mại phải là dạng chữ số',
            'sale_price.between' => 'Giá khuyến mại phải nhỏ hơn '.$request->price,
        ];
        $request->validate($rules, $mag);
        $form_data = $request->only('name', 'image', 'price', 'sale_price', 'content', 'status', 'category_id');
        if ($request->has('file_upload')) {
            $file = $request->file_upload;
            $ext = $request->file_upload->extension();
            $file_name = time() . '-' . 'product.' . $ext;
            $file_name = time() . $file->getClientoriginalName();
            $file->move(public_path('uploads'), $file_name);
        } else {

            $file_name = $pro->image;
        }
        $form_data['image'] =  $file_name;

        $orther_image = $request->orther_image;

        if ($orther_image && count($orther_image)) {
            foreach ($orther_image as $key => $othImage) {
                $ext = $othImage->extension();
                $file_name1 = 'Product' . time() . '-' . $key . '-' . $ext;
                if ($othImage->move(public_path('uploads'), $file_name1)) {
                    Image::create([
                        'product_id' => $pro->id,
                        'image' => $file_name1
                    ]);
                }
            }
        }

        //    $pro->update($form_data);
        if ($pro->update($form_data)) {
            return redirect()->route('product.index')->with('success', 'Sửa thành công');
        }
        return redirect()->back()->with('error', 'Sửa không thành công!');
    }

    public function clear(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach ($ids as $id) {
            $pro = Product::find($id);
            if ($pro->hasDetail()->count() == 0) {
                $pro->delete();
                $n++;
            } else {
                $n1++;
            }
        }

        return redirect()->route('product.index')->with('success', 'Đã xóa ' . $n . ' sản phẩm và có ' . $n1 . ' sản phẩm không thể xóa');
    }

    public function retrieve(Request $request)
    {
        $ids = $request->id;
        foreach ($ids as $id) {
            $pro = Product::withTrashed()->find($id);
            if ($pro) {
                $pro->restore();
            }
        }
        return redirect()->route('product.index')->with('success', 'Khôi phục thành công!');
    }


    public function trashed()
    {
        $data1 = Product::onlyTrashed()->paginate(6);
        return view('admin.product.trashed', compact('data1'));
    }
    public function restore($id)
    {
        $pro = Product::withTrashed()->find($id);
        $pro->restore();
        return redirect()->route('product.index')->with('success', 'Khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        $pro = Product::withTrashed()->find($id);
        $pro->forceDelete();
        return redirect()->route('product.index')->with('success', 'Xóa vĩnh viễn danh mục thành công!');
    }
    public function deleteAll(Request $req)
    {
        $ids = $req->id;
        foreach ($ids as $id) {
            $pro = Product::withTrashed()->find($id);
            if ($pro) {
                $pro->forceDelete();
            }
        }

        return redirect()->route('product.index')->with('success', 'Đã xóa vĩnh viễn thàn công');
    }
}
