@extends('layouts.user.app')
@section('title', 'Checkout')
@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Checkout</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($cart && count($cart) > 0)
            <div class="row">
                <!-- Ringkasan Pesanan -->
                <div class="col-md-7">
                    <h4 class="fw-bold mb-3">Ringkasan Pesanan</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($cart as $id => $item)
                                @php
                                    $total = $item['harga'] * $item['quantity'];
                                    $grandTotal += $total;
                                @endphp
                                <tr>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="fw-bold text-end">Grand Total:</td>
                                <td class="fw-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- Form Data Pembeli -->
                <div class="col-md-5">
                    <h4 class="fw-bold mb-3">Data Pembeli</h4>
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Pengiriman</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">No. Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="metode" class="form-label">Metode Pembayaran</label>
                            <select name="metode" id="metode" class="form-select" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="cod">Cash on Delivery (COD)</option>
                                <option value="ewallet">E-Wallet (OVO, Dana, GoPay)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-lg">Proses
                            Pembayaran</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-warning">Keranjang masih kosong.</div>
            <a href="/" class="btn btn-secondary mt-3">Lanjut Belanja</a>
        @endif
    </div>
@endsection
