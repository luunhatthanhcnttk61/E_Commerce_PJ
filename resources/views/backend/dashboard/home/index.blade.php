{{-- Thống kê tổng quan --}}
<div class="row m-3">
    <div class="col-md-4">
        <div class="ibox bg-primary text-white shadow">
            <div class="ibox-title"><i class="fa fa-shopping-cart"></i> Tổng đơn hàng</div>
            <div class="ibox-content">
                <h2 class="no-margins">{{ $totalOrders ?? 0 }}</h2>
                <small>Đơn hàng đã tạo</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ibox bg-success text-white shadow">
            <div class="ibox-title"><i class="fa fa-money"></i> Tổng doanh thu</div>
            <div class="ibox-content">
                <h2 class="no-margins">{{ number_format($totalRevenue ?? 0) }} đ</h2>
                <small>Đơn thành công</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ibox bg-warning text-white shadow">
            <div class="ibox-title"><i class="fa fa-users"></i> Tổng khách hàng</div>
            <div class="ibox-content">
                <h2 class="no-margins">{{ $totalCustomers ?? 0 }}</h2>
                <small>Khách đã đăng ký</small>
            </div>
        </div>
    </div>
</div>

{{-- Biểu đồ doanh thu --}}
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-title"><i class="fa fa-bar-chart"></i> Doanh thu theo tháng</div>
            <div class="ibox-content">
                <canvas id="revenueChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($ordersByMonth)) !!},
            datasets: [{
                label: 'Doanh thu',
                data: {!! json_encode(array_values($ordersByMonth)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(255,99,132,1)'
            }]
        },
        options: {
            plugins: {
                legend: { display: true }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tháng',
                        align: 'end'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Doanh thu (đ)',
                        align: 'end'
                    }
                }
            }
        }
    });
</script>

{{-- Bảng đơn hàng mới --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-title"><i class="fa fa-list"></i> Đơn hàng mới nhất</div>
            <div class="ibox-content table-responsive">
                <table class="table table-bordered table-hover mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestOrders as $order)
                        <tr>
                            <td><span class="badge badge-info">{{ $order->order_code }}</span></td>
                            <td>{{ $order->name }}</td>
                            <td>{{ number_format($order->total_amount) }} đ</td>
                            <td>
                                @if($order->order_status == 'success')
                                    <span class="badge badge-success">Thành công</span>
                                @elseif($order->order_status == 'pending')
                                    <span class="badge badge-warning">Chờ xử lý</span>
                                @else
                                    <span class="badge badge-danger">{{ $order->order_status }}</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if(count($lowStockProducts))
<div class="alert alert-danger mt-3">
    <i class="fa fa-exclamation-triangle"></i>
    <strong>Cảnh báo!</strong> Có {{ count($lowStockProducts) }} sản phẩm sắp hết hàng:
    <ul class="mb-0">
        @foreach($lowStockProducts as $product)
            <li>{{ $product->name }} <span class="badge badge-danger">Còn {{ $product->inventory }}</span></li>
        @endforeach
    </ul>
</div>
@endif


<style>
.ibox {
    border-radius: 8px;
    margin-bottom: 20px;
    padding: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}
.ibox-title {
    font-weight: bold;
    font-size: 16px;
    padding: 12px 20px 8px 20px;
    background: rgba(0,0,0,0.03);
    border-radius: 8px 8px 0 0;
}
.ibox-content {
    padding: 20px;
}
.bg-primary { background: linear-gradient(90deg,#007bff 60%,#0056b3 100%) !important; }
.bg-success { background: linear-gradient(90deg,#28a745 60%,#218838 100%) !important; }
.bg-warning { background: linear-gradient(90deg,#ffc107 60%,#e0a800 100%) !important; }
.text-white { color: #910101 !important; }
.shadow { box-shadow: 0 4px 16px rgba(0,0,0,0.08) !important; }
.badge { font-size: 90%; }
</style>