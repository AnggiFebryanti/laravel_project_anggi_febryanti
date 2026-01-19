@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="bx bx-receipt me-2"></i>Riwayat Pesanan
                        </h4>
                    </div>
                    <div class="card-body">
                        @if ($orders->count() == 0)
                            <div class="alert alert-info text-center">
                                <i class="bx bx-receipt display-4 d-block mb-3"></i>
                                <h5>Belum Ada Pesanan</h5>
                                <p class="mb-3">Anda belum melakukan pesanan apapun.</p>
                                <a href="{{ route('products.userIndex') }}" class="btn btn-primary">
                                    <i class="bx bx-store me-2"></i>Lihat Produk
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>
                                                    <strong>#{{ $order->id }}</strong>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($order->tanggal)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    <strong class="text-primary">
                                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                                    </strong>
                                                </td>
                                                <td>
                                                    <span class="{{ $order->status_badge }}">
                                                        {{ ucfirst($order->status_pembayaran) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('orders.show', $order->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if ($orders->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $orders->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
