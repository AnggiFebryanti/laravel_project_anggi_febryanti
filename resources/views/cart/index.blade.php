@extends('layouts.user.app')
@section('title', 'Keranjang Pesanan')
@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Keranjang Pesanan</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($cart && count($cart) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
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
                            <td>
                                <img src="{{ asset('storage/' . $item['foto']) }}" width="60" class="me-2">
                                {{ $item['nama'] }}
                            </td>
                            <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                        class="form-control w-50 me-2">
                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                </form>
                            </td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                        <td colspan="2" class="fw-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
            <!-- Bagian Total + Tombol Checkout -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4 class="fw-bold">Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}</h4>
                <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg">
                    Lanjut ke Pembayaran
                </a>
            </div>
        @else
            <div class="alert alert-warning">Keranjang masih kosong.</div>
        @endif
        <a href="/" class="btn btn-secondary mt-3">Lanjut Belanja</a>
    </div>
@endsection
