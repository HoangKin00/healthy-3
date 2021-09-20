@extends ('layout.admin')
@section('title','Thêm Mới Comment ')
@section('main')
<div class="container">
    <div class="card card-primary">
        <form action="{{ route('comment.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên nhà thiết kế</label>
                            <input type="" class="form-control" id="exampleInputEmail1" placeholder="Tên nhà thiết kế" name="name" value="{{old('name')}}">
                            @error('name')<small style="color: red;">*{!!$message!!}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội Dung</label>
                            <textarea name="content" class="form-control content-editor" value="{{old('content')}}"> </textarea>
                            @error('content')<small style="color: red;">*{{$message}}</small> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputPassword1">Chức vụ</label>
                            <input type="text" name="position" class="form-control" id="exampleInputPassword1" placeholder="Chức vụ" value="{{old('position')}}">
                            @error('position')<small style="color: red;">*{{$message}}</small> @enderror
                        </div>

                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" id="input" value="0" checked>
                                    Ẩn
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" id="input" value="1">
                                    Hiển Thị
                                </label>
                            </div>

                        </div>

                        <div class="form-group">
                            <span class="btn btn-success col fileinput-button">
                                <i class="fas fa-plus"></i>
                                <span>Add files</span>
                            </span>
                            <img src="https://rpfinancelk.com/wp-content/uploads/2020/12/no-image-available-icon-photo-camera-flat-vector-illustration-132483097.jpg" id="show_img" width="100%">
                            <input type="file" name="file_upload" id="select_file" value="{{old('file_upload')}}" style="display:none">
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
</script>

@stop
