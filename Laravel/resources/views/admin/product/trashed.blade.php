@extends ('layout.admin')
@section('title','Sản phẩm')
@section('main')
<div class="container">
    <div class="d-flex">
        <form class="form-inline">
            <input class="form-control " name="key" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <a href="{{route('product.create')}}" type="button" class="btn btn-info" style="margin-left: 15px;"><i class="fas fa-plus"></i>Thêm Mới</a>
        <a href="" type="button" class="btn btn-warning btn-restore-all ml-2"><i class="fas fa-window-restore"></i>Khôi phục sản phẩm</i></a>
        <a href="" type="button" class="btn btn-danger btn-delete-all ml-2"><i class="fas fa-trash nav-icon"> Xóa lựa chọn </i></a>
    </div>
    <hr>
    <form action="{{route('product.retrieve')}}" method="POST" id="formRestore">
        @csrf @method('GET')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        <div class="icheck-success d-inline">
                            <input type="checkbox" id="check_all">
                            <label for="check_all">
                            </label>
                        </div>
                    </th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Sale_Price</th>
                    <th scope="col">Image</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Deleted at</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data1 as $pro)
                <tr>
                    <td>
                        <div class="icheck-success d-inline">
                            <input type="checkbox" name="id[]" value="{{$pro->id}}" id="item-{{$pro->id}}" class="check_item">
                            <label for="item-{{$pro->id}}">
                            </label>
                        </div>
                    </td>
                    <td>{{$pro->id}}</td>
                    <td>{{$pro->name}}</td>
                    <td>{{$pro->price}}</td>
                    <td>{{$pro->sale_price}}</td>
                    <td>
                        <img src="{{url('public/uploads')}}/{{$pro->image}}" alt="" width="100" height="100">
                    </td>
                    <td>{{$pro->created_at ? $pro->created_at->format('d-m-Y') : ''}}</td>
                    <td>{{$pro->deleted_at ? $pro->deleted_at->format('d-m-Y') : ''}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{route('product.edit', $pro->id)}}" class="btn btn-primary" style="margin-right: 10px;"><i class="fas fa-edit"></i></a>
                            <a href="{{route('product.restore',$pro->id)}}" title="Phục hồi" class="btn btn-warning " style="margin-right: 10px;"><i class="fas fa-window-restore"></i></a>
                            <a href="{{route('product.forceDelete',$pro->id)}}" onclick="return confirm('Bạn có chắc muốn xóa không?');" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </form>
    <div class="text-center">
        {{$data1 -> links()}}
    </div>
</div>
<form action="{{route('product.deleteAll')}}" method="POST" id="formDeleteAll" value="">
    @csrf @method('DELETE')
    <div id="idDelete"></div>
</form>
@stop()
@section('css')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ url('public/admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@stop
@section('js')
<script>
    $('a.btn-restore-all').hide()
    $('a.btn-delete-all').hide()
    $('input#check_all').click(function() {
        var isCheck = $(this).is(':checked');
        if (isCheck) {
            $('input.check_item').prop('checked', true);
            $('a.btn-restore-all').show();
            $('a.btn-delete-all').show();
        } else {
            $('input.check_item').prop('checked', false);
            $('a.btn-restore-all').hide();
            $('a.btn-delete-all').hide();
        }
        $('#idDelete').html('');
        $('input.check_item').each(function() {
            if ($(this).is(':checked')) {
                var input = $(this).attr('value');
                var id_input = '<input type="hidden" name="id[]" value="' + input + '">';
                console.log(id_input);
                $('#idDelete').append(id_input);
            }
        });
    });
    $('input.check_item').click(function() {

        var isCheckLength = $('input.check_item:checked').length;
        if (isCheckLength > 0) {
            $('a.btn-restore-all').show();
            $('a.btn-delete-all').show();
        } else {
            $('a.btn-delete-all').hide();
            $('a.btn-restore-all').hide();
        }
    });

    $('a.btn-restore-all').click(function(ev) {
        ev.preventDefault();
        if (confirm('Bạn có muốn khôi phục không?')) {
            $('form#formRestore').submit();
        }
    })

    //xóa nhiều sp

    $('input.check_item').click(function() {
        $('#idDelete').html('');
        $('input.check_item').each(function() {
            if ($(this).is(':checked')) {
                var input = $(this).attr('value');
                var id_input = '<input type="hidden" name="id[]" value="' + input + '">';
                console.log(id_input);
                $('#idDelete').append(id_input);
            }
        });
    })

    $('a.btn-delete-all').click(function(ev) {
        ev.preventDefault();

        if (confirm('Bạn có muốn xóa không?')) {
            $('form#formDeleteAll').submit();
        }
    })
</script>
@stop
