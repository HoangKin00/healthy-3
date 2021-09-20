@extends ('layout.admin')
@section('title','Quản trị viên')
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
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <a href="{{route('admin.create')}}" type="button" class="btn btn-info" style="margin-left: 15px;"><i class="fas fa-plus"></i>Thêm Mới</a>
    </div>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>

                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data1 as $adm)
            <tr>
                <th scope="row">{{$adm->id}}</th>
                <td>{{$adm->name}}</td>
                <td>{{$adm->email}}</td>
                <td>{{$adm->phone}}</td>

                <td>
                    <div class="d-flex">
                        <a href="{{route('admin.edit', $adm->id)}}" class="btn btn-primary" style="margin-right: 10px;"><i class="fas fa-edit"></i></a>
                        <form action="{{route('admin.destroy', $adm->id)}}" method="POST">
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
