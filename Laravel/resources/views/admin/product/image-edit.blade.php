@extends ('layout.admin')
@section('title','Sửa ảnh phụ')
@section('main')
<div class="container">
    <div class="col-8">
        <div class="card card-info">

            <!-- /.card-header -->
            <!-- form start -->

            <form class="form-horizontal" action="{{route('product.image-update', $image->id)}}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="col-6">
                        <div class="form-group">
                            <span class="btn btn-success col fileinput-button">
                                <i class="fas fa-plus"></i>
                                <span>Chọn ảnh</span>
                            </span>
                            <hr>
                            @if(isset($image->image))
                            <img src="{{url('public/uploads')}}/{{$image->image}}" id="show_img" width="100%" height="100%">
                            @else
                            <img src="https://rpfinancelk.com/wp-content/uploads/2020/12/no-image-available-icon-photo-camera-flat-vector-illustration-132483097.jpg" id="show_img" width="100%">
                            @endif
                            <input type="file" name="file_upload" id="select_file" value="{{$image->image}}" style="display:none">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href=""> <button type="submit" class="btn btn-info"><i class="fas fa-save"></i>Lưu
                            Lại</button></a>
                    <a href="{{route('product.edit', $image->product_id)}}"> <button type="submit" class="btn btn-default float-right"><i class="fas fa-arrow-left"></i>Bỏ qua</button></a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
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
