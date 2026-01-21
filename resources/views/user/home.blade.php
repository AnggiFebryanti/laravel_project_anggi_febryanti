@extends('layouts.user.app')
@section('title', 'Dashboard')
@section('content')
    <!-- Hero Section -->
    <section class="py-5 bg-light text-center">
        <div class="container">
            <h1 class="fw-bold mb-3">Selamat Datang di <span class="textprimary">TokoKu</span></h1>
            <p class="lead text-muted">Belanja mudah, cepat, dan terpercaya dengan produk
                pilihan terbaik.</p>
            <a href="#produk" class="btn btn-primary btn-lg mt-3">Belanja Sekarang</a>
        </div>
    </section>
    <!-- Produk Section -->
    <div class="container">
        <section id="produk" class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold">Produk Unggulan</h2>
                <div class="row g-5 mt-3">
                    @forelse($products as $product)
                        <div class="col-md-3">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('storage/' . $product->foto) }}" class="card-img-top"
                                    alt="{{ $product->nama }}">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $product->nama }}</h5>
                                    <p class="card-text text-muted">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary">Produk
                                        Detail </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Belum ada produk tersedia.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
