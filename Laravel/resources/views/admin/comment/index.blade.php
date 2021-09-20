@extends ('layout.admin')
@section('title',' Comment')
@section('main')
<div class="container">
    <div class="d-flex">
        <form class="form-inline">
            <input class="form-control" name="key" type="search" placeholder="Search" aria-label="Search">
            <select name="order" id="input" class="form-control">
                <option value="">Sắp xếp</option>
                @foreach($orderByOptions as $key => $value)
                <option value="{{$key}}" {{request()->order == $key ? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>

            <select name="status" id="input" class="form-control">
                <option value="">Mặc định</option>
                <option value="2" {{request()->status == 2 ? 'selected' : ''}}>Ẩn</option>
                <option value="1" {{request()->status == 1 ? 'selected' : ''}}>Hiển Thị</option>
            </select>

            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <a href="{{route('comment.create')}}" type="button" class="btn btn-info" style="margin-left: 15px;"><i class="fas fa-plus"></i>Thêm Mới</a>
        <a href="" type="button" class="btn btn-danger btn-delete-all ml-2"><i class="fas fa-trash nav-icon"> Xóa lựa chọn </i></a>
    </div>
    <hr>
    <form action="{{route('comment.clear')}}" method="POST" id="formDeleteAll">
        @csrf @method('DELETE')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">
                        <div class="icheck-success d-inline">
                            <input type="checkbox" id="check_all">
                            <label for="check_all">
                            </label>
                        </div>
                    </th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $com)
                <tr>
                    <td>
                        <div class="icheck-success d-inline">
                            <input type="checkbox" name="id[]" value="{{$com->id}}" id="item-{{$com->id}}" class="check_item">
                            <label for="item-{{$com->id}}">
                            </label>
                        </div>
                    </td>
                    <td scope="row">{{$com->id}}</td>
                    <td>{{$com->name}}</td>
                    <td>
                        <img src="{{url('public/uploads')}}/{{$com->image}}" alt="" width="100" height="100">
                    </td>
                    <td>{{$com->status == 0 ? 'Ẩn' : 'Hiển Thị'}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{route('comment.edit', $com->id)}}" class="btn btn-primary" style="margin-right: 10px;"><i class="fas fa-edit"></i></a>
                            <a href="{{route('comment.destroy', $com->id)}}" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    <div class="text-center">
        {{$data -> links()}}
    </div>
</div>
<form action="" method="POST" id="singleDelete">
    @csrf @method('DELETE')
</form>
@stop()
@section('css')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ url('public/admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@stop
@section('js')
<script>
    $('a.btn-delete-all').hide()
    $('input#check_all').click(function() {
        var isCheck = $(this).is(':checked');
        if (isCheck) {
            $('input.check_item').prop('checked', true);
            $('a.btn-delete-all').show();
        } else {
            $('input.check_item').prop('checked', false);
            $('a.btn-delete-all').hide();
        }
    });
    $('input.check_item').click(function() {

        var isCheckLength = $('input.check_item:checked').length;
        if (isCheckLength > 0) {
            $('a.btn-delete-all').show();
        } else {
            $('a.btn-delete-all').hide();
        }
    });

    //Xóa 1 sp
    $('a.btn-single-delete').click(function(ev) {
        ev.preventDefault();
        var href = $(this).attr('href');
        $('form#singleDelete').attr('action', href);
        if (confirm('Bạn có muốn xóa không?')) {
            $('form#singleDelete').submit();
        }
    })

    $('a.btn-delete-all').click(function(ev) {
        ev.preventDefault();
        if (confirm('Bạn có muốn xóa không?')) {
            $('form#formDeleteAll').submit();
        }
    })
</script>
@stop
