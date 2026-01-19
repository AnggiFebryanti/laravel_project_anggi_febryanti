@extends('layouts.app')

@section('title', $product->nama)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Product Details -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('products.userIndex') }}">Produk</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $product->nama }}
                                </li>
                            </ol>
                        </nav>

                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                @if ($product->foto)
                                    <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}"
                                        class="img-fluid rounded">
                                @else
                                    <img src="{{ asset('assets/img/elements/11.jpg') }}" alt="{{ $product->nama }}"
                                        class="img-fluid rounded">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h2 class="card-title mb-3">{{ $product->nama }}</h2>

                                <div class="mb-3">
                                    <span class="badge bg-light-primary text-primary">
                                        <i class="bx bx-category me-1"></i>
                                        {{ $product->category ? $product->category->nama : 'No Category' }}
                                    </span>
                                </div>

                                <h3 class="text-primary mb-3">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </h3>

                                <div class="mb-3">
                                    <p class="card-text">
                                        <i class="bx bx-package me-2"></i>
                                        <span class="{{ $product->stok > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $product->stok > 0 ? 'Tersedia (' . $product->stok . ')' : 'Stok Habis' }}
                                        </span>
                                    </p>
                                </div>

                                @if ($product->deskripsi)
                                    <div class="mb-4">
                                        <h5 class="mb-2">Deskripsi</h5>
                                        <p class="card-text">{{ $product->deskripsi }}</p>
                                    </div>
                                @endif

                                @if ($product->stok > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                        class="d-flex gap-2">
                                        @csrf
                                        <div class="input-group" style="max-width: 200px;">
                                            <span class="input-group-text">Jumlah</span>
                                            <input type="number" name="qty" class="form-control" value="1"
                                                min="1" max="{{ $product->stok }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary flex-grow-1">
                                            <i class="bx bx-cart-add me-2"></i>Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="bx bx-cart me-2"></i>Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-bookmark me-2"></i>Produk Terkait
                        </h5>
                    </div>
                    <div class="card-body">
                        @forelse($relatedProducts as $related)
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    @if ($related->foto)
                                        <img src="{{ asset('storage/' . $related->foto) }}" alt="{{ $related->nama }}"
                                            width="80" height="80" style="object-fit: cover;" class="rounded">
                                    @else
                                        <img src="{{ asset('assets/img/elements/11.jpg') }}" alt="{{ $related->nama }}"
                                            width="80" height="80" style="object-fit: cover;" class="rounded">
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $related->nama }}</h6>
                                    <p class="text-primary mb-0 mb-1">
                                        Rp {{ number_format($related->harga, 0, ',', '.') }}
                                    </p>
                                    <small class="text-muted">Stok: {{ $related->stok }}</small>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('products.userShow', $related->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center mb-0">
                                Tidak ada produk terkait.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
