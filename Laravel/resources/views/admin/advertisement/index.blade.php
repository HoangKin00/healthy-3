@extends ('layout.admin')
@section('title',' Advertisement')
@section('main')
<div class="container">
    <div class="d-flex">
        <form class="form-inline">
            <input class="form-control " name="key" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <!-- <a href="{{route('banner.create')}}" type="button" class="btn btn-info" style="margin-left: 15px;"><i class="fas fa-plus"></i>Thêm Mới</a> -->
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
            @foreach($data as $adv)
            <tr>
                <th scope="row">{{$adv->id}}</th>
                <td>{{$adv->name}}</td>
                <td>
                    <img src="{{url('public/uploads')}}/{{$adv->image}}" alt="" width="200" height="100">
                </td>
                <td>{{$adv->status == 0 ? 'Ẩn' : 'Hiển Thị'}}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{route('advertisement.edit',$adv->id)}}" class="btn btn-primary" ><i class="fas fa-edit"></i></a>
                        <!-- <a href="" class="btn btn-danger"><i class="fas fa-trash"></i></a> -->
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-center">
        {{$data -> links()}}
    </div>
</div>

@stop()
