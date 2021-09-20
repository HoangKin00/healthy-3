@extends ('layout.admin')
@section('title',' Banner')
@section('main')
<div class="container">
    <div class="d-flex">
        <form class="form-inline">
            <input class="form-control " name="key" type="search" placeholder="Search" aria-label="Search">
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
        <a href="{{route('banner.create')}}" type="button" class="btn btn-info" style="margin-left: 15px;"><i class="fas fa-plus"></i>Thêm Mới</a>
    </div>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data1 as $ban)
            <tr>
                <th scope="row">{{$ban->id}}</th>
                <td>{{$ban->name}}</td>
                <td>
                    <img src="{{url('public/uploads')}}/{{$ban->image}}" alt="" width="200" height="100">
                </td>
                <td>{{$ban->status == 0 ? 'Ẩn' : 'Hiển Thị'}}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{route('banner.edit', $ban->id)}}" class="btn btn-primary" style="margin-right: 10px;"><i class="fas fa-edit"></i></a>
                        <form action="{{route('banner.destroy', $ban->id)}}" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Bạn có chắc muốn xóa không?');" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-center">
        {{$data1 -> links()}}
    </div>
</div>

@stop()
