@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Breadcrumb dinamis --}}
        <x-breadcrumb :items="[
            'Produk' => route('products.index'),
            'Edit Produk' => '',
        ]" />
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
            <!-- Basic with Icons -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama">Nama Produk</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-package"></i></span>
                                        <input type="text" name="nama"
                                            class="form-control @error('nama') is-invalid @enderror" id="nama"
                                            placeholder="Silahkan isi nama produk"
                                            value="{{ old('nama', $product->nama) }}" />
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kategori_id">Kategori</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-category"></i></span>
                                        <select name="kategori_id" id="kategori_id"
                                            class="form-select @error('kategori_id') is-invalid @enderror">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('kategori_id', $product->kategori_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label" for="harga">Harga</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-dollar-circle"></i></span>
                                        <input type="number" name="harga" id="harga"
                                            class="form-control @error('harga') is-invalid @enderror" placeholder="10000"
                                            value="{{ old('harga', $product->harga) }}" />
                                        @error('harga')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label" for="stok">Stok</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-box"></i></span>
                                        <input type="number" name="stok" id="stok"
                                            class="form-control @error('stok') is-invalid @enderror" placeholder="10"
                                            value="{{ old('stok', $product->stok) }}" />
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 form-label" for="deskripsi">Deskripsi</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-comment-detail"></i></span>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                            placeholder="Silahkan isi deskripsi produk">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="foto">Gambar</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="file" name="foto"
                                            class="form-control @error('foto') is-invalid @enderror" id="foto" />
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if ($product->foto)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}"
                                                class="img-thumbnail" width="150">
                                            <p class="mt-1"><small>Gambar saat ini.</small></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
