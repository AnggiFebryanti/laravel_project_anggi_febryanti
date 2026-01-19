@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="bx bx-receipt me-2"></i>Detail Pesanan #{{ $order->id }}
                            </h4>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bx bx-left-arrow-alt me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Order Info -->
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-1 text-muted">Tanggal Pesanan</p>
                                        <h5 class="mb-0">{{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-1 text-muted">Status Pembayaran</p>
                                        <h5 class="mb-0">
                                            <span class="{{ $order->status_badge }}">
                                                {{ ucfirst($order->status_pembayaran) }}
                                            </span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-1 text-muted">Jumlah Item</p>
                                        <h5 class="mb-0">{{ $order->orderProducts->count() }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-1 text-muted">Total</p>
                                        <h5 class="mb-0 text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Item Pesanan</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Produk</th>
                                                <th width="150">Harga Satuan</th>
                                                <th width="150">Jumlah</th>
                                                <th width="150">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderProducts as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-3">
                                                                @if ($item->product && $item->product->foto)
                                                                    <img src="{{ asset('storage/' . $item->product->foto) }}"
                                                                        alt="{{ $item->product->nama }}" width="80"
                                                                        height="80" style="object-fit: cover;"
                                                                        class="rounded">
                                                                @else
                                                                    <img src="{{ asset('assets/img/elements/11.jpg') }}"
                                                                        alt="{{ $item->product->nama ?? 'Produk tidak tersedia' }}"
                                                                        width="80" height="80"
                                                                        style="object-fit: cover;" class="rounded">
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-1">
                                                                    {{ $item->product->nama ?? 'Produk tidak tersedia' }}
                                                                </h6>
                                                                <small class="text-muted">
                                                                    {{ $item->product->category->nama ?? 'No Category' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">Rp
                                                            {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-label-primary">
                                                            {{ $item->jumlah }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <strong class="text-primary">
                                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                        </strong>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Total Summary -->
                                <div class="row mt-4">
                                    <div class="col-md-6 offset-md-6">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Subtotal:</span>
                                                    <span>Rp
                                                        {{ number_format($order->orderProducts->sum('subtotal'), 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Biaya Pengiriman:</span>
                                                    <span class="text-success">Gratis</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Pajak:</span>
                                                    <span class="text-success">Rp 0</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-0">Total Pembayaran:</h5>
                                                    <h4 class="text-primary mb-0">
                                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
