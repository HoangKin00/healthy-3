@extends ('layout.admin')
@section('title', 'Đơn hàng')
@section('main')
    <div class="container">
        <form class="form-inline">
            <input class="form-control " name="key" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $item)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td scope="row">{{ $item->name }}</td>
                        <td scope="row">{{ $item->email }}</td>
                        <td scope="row">{{ $item->phone }}</td>
                        <td>{{ $item->created_at->format('d-m-Y') }}
                            <span
                                class="badge badge-pill badge-secondary">{{ $item->created_at->format('h:i:s') }}</span>
                        </td>
                        <td>{{ number_format($item->total_price) }}</td>
                        <td>
                            @if ($item->status == 0)
                                <span class="badge badge-pill badge-secondary">Chưa xác nhận</span>
                            @elseif ($item->status == 1)
                                <span class="badge badge-pill badge-info">Đã xác nhận</span>
                            @elseif ($item->status == 2)
                                <span class="badge badge-pill badge-warning">Đang giao hàng</span>
                            @elseif ($item->status == 3)
                                <span class="badge badge-pill badge-success">Đã giao hàng</span>
                            @elseif ($item->status == 4)
                                <span class="badge badge-pill badge-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.order.detail', $item->id) }}" class="btn btn-primary"><i
                                    class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">
            {{ $orders->links() }}
        </div>
    </div>
@stop()
