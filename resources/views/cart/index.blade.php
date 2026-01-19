@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="bx bx-cart-alt me-2"></i>Keranjang Belanja
                        </h4>
                    </div>
                    <div class="card-body">
                        @if (empty($cart))
                            <div class="alert alert-info text-center">
                                <i class="bx bx-shopping-bag display-4 d-block mb-3"></i>
                                <h5>Keranjang Anda Kosong</h5>
                                <p class="mb-3">Anda belum menambahkan produk ke keranjang.</p>
                                <a href="{{ route('products.userIndex') }}" class="btn btn-primary">
                                    <i class="bx bx-store me-2"></i>Lihat Produk
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produk</th>
                                            <th width="150">Harga</th>
                                            <th width="150">Jumlah</th>
                                            <th width="150">Subtotal</th>
                                            <th width="100">Aksi</th>
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
                                                                    alt="{{ $item['nama'] }}" width="80" height="80"
                                                                    style="object-fit: cover;" class="rounded">
                                                            @else
                                                                <img src="{{ asset('assets/img/elements/11.jpg') }}"
                                                                    alt="{{ $item['nama'] }}" width="80" height="80"
                                                                    style="object-fit: cover;" class="rounded">
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">{{ $item['nama'] }}</h6>
                                                            <small class="text-muted">Stok tersedia:
                                                                {{ $item['stok'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0">Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST"
                                                        class="d-flex align-items-center">
                                                        @csrf
                                                        <input type="number" name="qty"
                                                            class="form-control form-control-sm" value="{{ $item['qty'] }}"
                                                            min="1" max="{{ $item['stok'] }}" style="width: 80px;"
                                                            onchange="this.form.submit()">
                                                    </form>
                                                </td>
                                                <td>
                                                    <p class="mb-0 fw-bold text-primary">
                                                        Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Yakin ingin menghapus produk ini dari keranjang?')">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger"
                                            onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                                            <i class="bx bx-x me-2"></i>Kosongkan Keranjang
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Total:</h5>
                                                <h4 class="text-primary mb-0">
                                                    Rp {{ number_format($total, 0, ',', '.') }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 mt-3">
                                        <i class="bx bx-credit-card me-2"></i>Lanjut ke Pembayaran
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
