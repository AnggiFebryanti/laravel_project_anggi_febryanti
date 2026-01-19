<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
  /**
   * Display the cart contents.
   */
  public function index()
  {
    $cart = Session::get('cart', []);
    $total = 0;

    foreach ($cart as $item) {
      $total += $item['harga'] * $item['qty'];
    }

    return view('cart.index', compact('cart', 'total'));
  }

  /**
   * Add a product to the cart.
   */
  public function add(Request $request, $product_id)
  {
    $product = Product::findOrFail($product_id);

    // Check if product has stock
    if ($product->stok < 1) {
      return back()->with('error', 'Produk tidak tersedia (stok habis).');
    }

    $qty = $request->input('qty', 1);

    // Validate quantity
    if ($qty < 1) {
      return back()->with('error', 'Jumlah minimal 1.');
    }

    if ($qty > $product->stok) {
      return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
    }

    $cart = Session::get('cart', []);

    // If product already in cart, update quantity
    if (isset($cart[$product_id])) {
      $newQty = $cart[$product_id]['qty'] + $qty;
      if ($newQty > $product->stok) {
        return back()->with('error', 'Total jumlah melebihi stok yang tersedia.');
      }
      $cart[$product_id]['qty'] = $newQty;
    } else {
      // Add new product to cart
      $cart[$product_id] = [
        'id' => $product->id,
        'nama' => $product->nama,
        'harga' => $product->harga,
        'qty' => $qty,
        'stok' => $product->stok,
        'foto' => $product->foto,
      ];
    }

    Session::put('cart', $cart);

    return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
  }

  /**
   * Update the quantity of a product in the cart.
   */
  public function update(Request $request, $product_id)
  {
    $cart = Session::get('cart', []);

    if (!isset($cart[$product_id])) {
      return back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    $qty = $request->input('qty', 1);

    if ($qty < 1) {
      return back()->with('error', 'Jumlah minimal 1.');
    }

    if ($qty > $cart[$product_id]['stok']) {
      return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
    }

    $cart[$product_id]['qty'] = $qty;
    Session::put('cart', $cart);

    return back()->with('success', 'Jumlah produk berhasil diupdate.');
  }

  /**
   * Remove a product from the cart.
   */
  public function remove($product_id)
  {
    $cart = Session::get('cart', []);

    if (isset($cart[$product_id])) {
      unset($cart[$product_id]);
      Session::put('cart', $cart);
      return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    return back()->with('error', 'Produk tidak ditemukan di keranjang.');
  }

  /**
   * Clear all items from the cart.
   */
  public function clear()
  {
    Session::forget('cart');
    return back()->with('success', 'Keranjang berhasil dikosongkan.');
  }
}
