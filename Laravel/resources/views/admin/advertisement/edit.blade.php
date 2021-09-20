@extends ('layout.admin')
@section('title','Sửa quảng cáo')
@section('main')
<div class="container">
    <div class="col-8">
        <div class="card card-info">
            <form class="form-horizontal" action="{{route('advertisement.update', $adv->id)}}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <label for="inputEmail3" class="">Tên quảng cáo</label>
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Tên Banner" name="name" value="{{$adv->name}}">
                            @error('name')<small style="color: red;">*{!!$message!!}</small> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="">
                            <label for="inputEmail3" class="">Trạng Thái</label>
                            <div class="form-check">
                                <input type="radio" name="status" id="input" value="0" {{$adv->status == 0 ? 'checked' : ''}}>
                                <label class="form-check-label" for="inlineRadio1">Ẩn</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="status" id="input" value="1" {{$adv->status == 1 ? 'checked' : ''}}>
                                <label class="form-check-label" for="inlineRadio1">Hiển Thị</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="btn btn-success col fileinput-button">
                            <i class="fas fa-plus"></i>
                            <span>Add files</span>
                        </span>
                        <img src="{{url('public/uploads')}}/{{$adv->image}}" id="show_img" width="100%" height="100%">
                        <input type="file" name="file_upload" id="select_file" value="{{$adv->image}}" style="display:none">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href=""> <button type="submit" class="btn btn-info"><i class="fas fa-save"></i>Lưu
                            Lại</button></a>
                    <a href="{{route('advertisement.index')}}"> <button type="submit" class="btn btn-default float-right"><i class="fas fa-arrow-left"></i>Bỏ qua</button></a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
$('.fileinput-button').click(function(){
    $('#select_file').click();
})
$('#select_file').change(function(){
    var file = $(this)[0].files[0];
    var reader = new FileReader();
    reader.onload = function(ev){
        $('img#show_img').attr('src',ev.target.result);
    }
    reader.readAsDataURL(file);
})
</script>

@stop
