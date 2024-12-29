<table class="table table-bordered table-striped text-center mt-4">
    <thead class="table-dark">
        <tr>
            <th>#ID đơn hàng</th>
            <th>Tên khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->address->recipient_name}}</td>
            <td>{{ number_format($order->total_amount) }} VND</td>
            <td>
                @if($order->status == 'pending')
                    <span class="badge bg-secondary">Chờ xử lý</span>
                @elseif($order->status == 'confirmed')
                    <span class="badge bg-primary">Đã xác nhận</span>
                @elseif($order->status == 'preparing')
                    <span class="badge bg-info">Đang chuẩn bị</span>
                @elseif($order->status == 'ready_to_ship')
                    <span class="badge bg-warning">Sẵn sàng giao</span>
                @elseif($order->status == 'delivered')
                    <span class="badge bg-success">Đã giao hàng</span>
                @elseif($order->status == 'cancelled')
                    <span class="badge bg-danger">Đã hủy</span>
                @elseif($order->status == 'returned')
                    <span class="badge bg-dark">Đã trả hàng</span>
                @endif
            </td>
            <td>{{ $order->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="/admin/order/{{ $order->id }}" class="btn btn-info btn-sm">Chi tiết</a>
                <a href="/admin/order/{{ $order->id }}/edit" class="btn btn-warning btn-sm">Sửa</a>
                <form action="/admin/order/{{ $order->id }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                </form>

                <!-- Nút Xác nhận -->
                @if($order->status != 'delivered' && $order->status != 'cancelled' && $order->status != 'returned')
                <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Xác nhận chuyển trạng thái đơn hàng?')">
                        Xác nhận
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Không có đơn hàng nào trong trạng thái này.</td>
        </tr>
        @endforelse
    </tbody>
</table>
