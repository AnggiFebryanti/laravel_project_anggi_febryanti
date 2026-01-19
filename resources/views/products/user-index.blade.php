@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Search and Filter -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bx bx-search"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Cari produk..." name="search"
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <select class="form-select" name="kategori">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bx bx-filter me-2"></i>Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-12">
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="mb-3">
                                        @if ($product->foto)
                                            <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}"
                                                class="card-img-top" style="height: 200px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/img/elements/11.jpg') }}" alt="{{ $product->nama }}"
                                                class="card-img-top" style="height: 200px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <h5 class="card-title mb-2">{{ $product->nama }}</h5>
                                    <p class="card-text text-muted mb-2">
                                        <small>{{ $product->category ? $product->category->nama : 'No Category' }}</small>
                                    </p>
                                    <h5 class="text-primary mb-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</h5>
                                    <p class="card-text mb-3">
                                        <small class="{{ $product->stok > 0 ? 'text-success' : 'text-danger' }}">
                                            <i class="bx bx-package me-1"></i>
                                            Stok: {{ $product->stok }}
                                        </small>
                                    </p>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('products.userShow', $product->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="bx bx-show me-2"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="bx bx-info-circle me-2"></i>
                                Tidak ada produk yang ditemukan.
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
