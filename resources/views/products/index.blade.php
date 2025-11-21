@extends('layouts.app')
@section('title', 'Daftar Produk')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Breadcrumb dinamis --}}
        <x-breadcrumb :items="[
            'Produk' => route('products.index'),
            'Daftar Produk' => '',
        ]" />

        @if (session('success'))
            <div class="alert alert-primary alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Responsive Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0">Daftar Produk</h5>
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus"></i> Tambah Data
                    </a>
                </div>
                <!-- Search Form -->
                <form action="{{ route('products.index') }}" method="GET" class="d-flex" style="width: 300px;">
                    <input type="text" name="search"
                        class="w-75 pr-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 me-2"
                        placeholder="Cari..." value="{{ request('search') }}">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="bx bx-search"></i>
                    </button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                    <td>
                                        @if ($product->foto)
                                            <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}"
                                                class="img-thumbnail" width="80">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->nama }}</td>
                                    <td>{{ $product->category->nama ?? 'N/A' }}</td>
                                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                    <td>{{ $product->stok }}</td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form id="delete-form-{{ $product->id }}"
                                            action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteConfirm('{{ $product->id }}')">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteConfirm(id) {
            Swal.fire({
                title: 'Yakin mau hapus produk ini?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
