@extends ('layout.admin')
@section('title','Sửa sản phẩm')
@section('main')
<div class="container-fluid">
    <div class="">
        <form action="{{ route('product.update', $pro->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-8">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm" name="name" value="{{$pro->name}}">
                            @error('name')<small style="color: red;">*{!!$message!!}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội Dung</label>
                            <textarea name="content" class="form-control content-editor" value="{{$pro->content}}"> {{$pro->content}}</textarea>
                            @error('content')<small style="color: red;">*{{$message}}</small> @enderror
                        </div>
                        <div class="input-group">
                            <span class="btn btn-success col-3 fileinput-orther">
                                <i class="fas fa-plus"></i>
                                <span>Chọn ảnh khác</span>
                            </span>
                            <hr>
                            <div id="show_other_image" class="row">

                            </div>
                            <input type="file" name="orther_image[]" id="orther_image" style="display:none" multiple>
                        </div>
                        <hr>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product_id</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($image as $img)
                                <tr>
                                    <td>{{$img->id}}</td>
                                    <td>{{$img->product_id}}</td>
                                    <td> <img src="{{url('public/uploads')}}/{{$img->image}}" id="show_img" width="60" height="60"></td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{route('product.image-edit', $img->id)}}" class="btn btn-primary" style="margin-right: 10px;"><i class="fas fa-edit"></i></a>
                                            <a href="{{route('product.image-destroy',  $img->id)}}" onclick="return confirm('Bạn có chắc muốn xóa không?');" class="btn btn-danger btn-delete btn-single-delete"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Danh mục</label>
                            <select name="category_id" id="input" class="form-control" required="required" value="{{$pro->category_id}}">
                                @foreach($data as $cat)
                                <option value="{{$cat->id}}" {{$cat->id == $pro->category_id ? 'selected':''}}>{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Giá tiền</label>
                            <input type="text" name="price" class="form-control" id="exampleInputPassword1" placeholder="Giá tiền" value="{{$pro->price}}">
                            @error('price')<small style="color: red;">*{{$message}}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Giá Khuyến Mãi</label>
                            <input type="text" name="sale_price" class="form-control" id="exampleInputPassword1" placeholder="Giá khuyến mãi" value="{{$pro->sale_price}}">
                            @error('sale_price')<small style="color: red;">*{{$message}}</small> @enderror
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" id="input" value="1" {{ $pro->status == 1 ? 'checked' : ''}}>
                                    Hàng Mới
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" id="input" value="2" {{ $pro->status == 2 ? 'checked' : ''}}>
                                    Khuyến Mãi
                                </label>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Chọn Ảnh</label>
                            <div class="">
                                <span class="btn btn-success col fileinput-button">
                                    <i class="fas fa-plus"></i>
                                    <span>Chọn Ảnh</span>
                                </span>
                                @if(isset($pro->image))
                                <img src="{{url('public/uploads')}}/{{$pro->image}}" id="show_img" width="100%" height="100%">
                                @else
                                <img src="https://rpfinancelk.com/wp-content/uploads/2020/12/no-image-available-icon-photo-camera-flat-vector-illustration-132483097.jpg" id="show_img" width="100%">
                                @endif
                                <input type="file" name="file_upload" id="select_file" value="{{$pro->image}}" style="display:none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <a href=""> <button type="submit" class="btn btn-info"><i class="fas fa-save"></i>Lưu
                        Lại</button></a>
                <a href="{{route('product.create')}}"> <button type="submit" class="btn btn-default float-right"><i class="fas fa-arrow-left"></i>Bỏ qua</button></a>
            </div>
        </form>
    </div>
</div>
@stop
@section('js')
<script>
    $('.fileinput-button').click(function() {
        $('#select_file').click();
    })
    $('#select_file').change(function() {
        var file = $(this)[0].files[0];
        var reader = new FileReader();
        reader.onload = function(ev) {
            $('img#show_img').attr('src', ev.target.result);
        }
        reader.readAsDataURL(file);
    })

    $('.fileinput-orther').click(function() {
        $('#orther_image').click();
    })
    $('#orther_image').change(function() {
        var files = $(this)[0].files;
        $('#show_other_image').html('');
        if (files && files.length) {
            for (let i = 0; i < files.length; i++) {
                const fi = files[i];
                var reader = new FileReader();
                reader.onload = function(ev) {
                    var _image = '<div class="col-md-3">';
                    _image += '<img src="' + ev.target.result + '" width="100%">';
                    _image += '</div>';
                    $('#show_other_image').append(_image);
                }
                reader.readAsDataURL(fi);
            }
        }
    })
</script>

@stop
