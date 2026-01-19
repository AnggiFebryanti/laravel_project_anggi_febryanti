@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="bx bx-credit-card me-2"></i>Checkout & Pembayaran
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Alert for simulated payment -->
                        <div class="alert alert-info">
                            <i class="bx bx-info-circle me-2"></i>
                            Ini adalah simulasi pembayaran. Tidak ada pembayaran asli yang akan diproses.
                        </div>

                        <div class="row">
                            <!-- Cart Summary -->
                            <div class="col-lg-8 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Ringkasan Pesanan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th class="text-center">Jumlah</th>
                                                        <th class="text-end">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cart as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 me-3">
                                                                        @if ($item['foto'])
                                                                            <img src="{{ asset('storage/' . $item['foto']) }}"
                                                                                alt="{{ $item['nama'] }}" width="60"
                                                                                height="60" style="object-fit: cover;"
                                                                                class="rounded">
                                                                        @else
                                                                            <img src="{{ asset('assets/img/elements/11.jpg') }}"
                                                                                alt="{{ $item['nama'] }}" width="60"
                                                                                height="60" style="object-fit: cover;"
                                                                                class="rounded">
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-1">{{ $item['nama'] }}</h6>
                                                                        <small class="text-muted">
                                                                            Rp
                                                                            {{ number_format($item['harga'], 0, ',', '.') }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge bg-label-primary">
                                                                    {{ $item['qty'] }}
                                                                </span>
                                                            </td>
                                                            <td class="text-end">
                                                                <strong>Rp
                                                                    {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</strong>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Summary -->
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Detail Pembayaran</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Subtotal:</span>
                                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
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
                                                <h5 class="mb-0">Total:</h5>
                                                <h4 class="text-primary mb-0">
                                                    Rp {{ number_format($total, 0, ',', '.') }}
                                                </h4>
                                            </div>
                                        </div>

                                        <form action="{{ route('checkout.process') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label class="form-label">Metode Pembayaran</label>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        id="cod" value="cod" checked>
                                                    <label class="form-check-label" for="cod">
                                                        <i class="bx bx-money me-2"></i>Cash on Delivery (COD)
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        id="transfer" value="transfer">
                                                    <label class="form-check-label" for="transfer">
                                                        <i class="bx bx-credit-card me-2"></i>Transfer Bank (Simulasi)
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Catatan (Opsional)</label>
                                                <textarea class="form-control" name="notes" rows="3" placeholder="Tambahkan catatan untuk pesanan Anda..."></textarea>
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="bx bx-check-circle me-2"></i>Bayar Sekarang
                                                </button>
                                            </div>
                                        </form>

                                        <div class="mt-3">
                                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                                                <i class="bx bx-left-arrow-alt me-2"></i>Kembali ke Keranjang
                                            </a>
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
