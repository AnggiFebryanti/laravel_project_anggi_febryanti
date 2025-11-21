<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index(): View
    {
        $products = Product::with('category')
            ->when(request('search'), function ($query) {
                $query->where('nama', 'like', '%' . request('search') . '%');
            })
            ->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form tambah produk
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imagePath = $request->file('foto')->store('products', 'public');

        Product::create([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'foto' => $imagePath,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit produk
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Mengupdate produk
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imagePath = $product->foto;
        if ($request->hasFile('foto')) {
            // Hapus gambar lama jika ada
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }
            // Simpan gambar baru
            $imagePath = $request->file('foto')->store('products', 'public');
        }

        $product->update([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'foto' => $imagePath,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk
     */
    public function destroy(Product $product)
    {
        // Hapus gambar dari storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
