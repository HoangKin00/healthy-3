@extends ('layout.admin')
@section('title','Thêm mới quản trị viên')
@section('main')
<div class="container">
    <div class="col-8">
        <div class="card card-primary">
            <form action="{{route('admin.add')}}" method="POST">
            @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên quản trị</label>
                        <input type="" name="name" class="form-control" id="exampleInputEmail1" placeholder="Tên Người Dùng"  value="{{old('name')}}">
                        @error('name')<small style="color: red;">*{!!$message!!}</small> @enderror

                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email" value="{{old('email')}}">
                        @error('email')<small style="color: red;">*{!!$message!!}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="{{old('password')}}">
                        @error('password')<small style="color: red;">*{{$message}}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Số Điện Thoại</label>
                        <input type="" name="phone" class="form-control" id="exampleInputPassword1" placeholder="Số Điện Thoại" value="{{old('phone')}}">
                        @error('phone')<small style="color: red;">*{{$message}}</small> @enderror
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href=""> <button type="submit" class="btn btn-info"><i class="fas fa-save"></i>Lưu
                            Lại</button></a>
                    <a href="{{route('admin.create')}}"> <button type="submit" class="btn btn-default float-right"><i class="fas fa-arrow-left"></i>Bỏ qua</button></a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop()
