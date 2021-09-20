@extends ('layout.admin')
@section('title', 'Chi tiết đơn hàng')
@section('main')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="heading_s1">Chi tiết đơn hàng</h2>
                    <p>Mã đơn hàng : {{ $order->id }}</p>
                    <p>Ngày đặt : {{ $order->created_at->format('d-m-Y') }}<span
                            class="badge badge-pill badge-secondary">{{ $order->created_at->format('h:i:s') }}</span></p>
                    <p>Tổng tiền: {{ number_format($order->total_price) }}</p>
                    <p>Trạng thái :
                        @if ($order->status == 0)
                            <span class="badge badge-pill badge-secondary">Chưa xác nhận</span>
                        @elseif ($order->status == 1)
                            <span class="badge badge-pill badge-info">Đã xác nhận</span>
                        @elseif ($order->status == 2)
                            <span class="badge badge-pill badge-warning">Đang giao hàng</span>
                        @elseif ($order->status == 3)
                            <span class="badge badge-pill badge-success">Đã giao hàng</span>
                        @elseif ($order->status == 4)
                            <span class="badge badge-pill badge-danger">Đã hủy</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                @if ($order->status != 3 && $order->status != 4)
                     <h2 class="heading_s1">Cập nhập trạng thái</h2>
                    <form action="{{ route('order.status', $order->id) }}" method="Post" style="display: flex;">
                        @csrf @method('PUT')
                        <select name="status" id="input" class="form-control"
                            style="width:34% !important;margin-top: -6px;">
                            <option value="0" {{$order->status == 0 ? 'selected' : ''}}>Chưa xác nhận</option>
                            <option value="1 "{{$order->status == 1 ? 'selected' : ''}}>Đã xác nhận</option>
                            <option value="2" {{$order->status == 2 ? 'selected' : ''}}>Đang giao hàng</option>
                            <option value="3" {{$order->status == 3 ? 'selected' : ''}}>Đã giao hàng</option>
                            <option value="4" {{$order->status == 4 ? 'selected' : ''}}>Đã hủy</option>
                        </select>
                        <button type="submit" class="btn btn-info" style="margin-top: -7px;">Cập nhập</button>
                    </form>
                @endif
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <h2 class="heading_s1">Thông tin người đặt hàng</h2>
                    <p>Họ tên : {{ $order->hasCus->name }}</p>
                    <p>Email : {{ $order->hasCus->email }}</p>
                    <p>Số điện thoại : {{ $order->hasCus->phone }}</p>
                    <p>Địa chỉ : {{ $order->hasCus->address }}</p>
                </div>
                <div class="col-md-6">
                    <h2>Thông tin người nhận hàng</h2>
                    <p>Họ tên : {{ $order->name }}</p>
                    <p>Email : {{ $order->email }}</p>
                    <p>Số điện thoại : {{ $order->phone }}</p>
                    <p>Địa chỉ : {{ $order->address }}</p>

                </div>
            </div>
            <h2 class="heading_s1">Lịch sử đơn hàng</h2>
            <table class="table table-bordered table-light">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $key => $item)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $item->hasPros->name }}</td>
                            <td>{{ number_format($item->price) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->quantity * $item->price) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@stop()
