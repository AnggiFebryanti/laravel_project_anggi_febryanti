<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
  /**
   * Display the checkout page with cart summary.
   */
  public function index()
  {
    $cart = Session::get('cart', []);

    if (empty($cart)) {
      return redirect()->route('products.userIndex')
        ->with('error', 'Keranjang kosong. Silakan tambahkan produk terlebih dahulu.');
    }

    $total = 0;
    foreach ($cart as $item) {
      $total += $item['harga'] * $item['qty'];
    }

    return view('checkout.index', compact('cart', 'total'));
  }

  /**
   * Process the checkout and create order.
   */
  public function process(Request $request)
  {
    $cart = Session::get('cart', []);

    if (empty($cart)) {
      return redirect()->route('products.userIndex')
        ->with('error', 'Keranjang kosong. Silakan tambahkan produk terlebih dahulu.');
    }

    // Validate cart items still have stock
    foreach ($cart as $item) {
      if ($item['qty'] > $item['stok']) {
        return back()->with('error', "Produk {$item['nama']} tidak memiliki stok yang cukup.");
      }
    }

    // Calculate total
    $total = 0;
    foreach ($cart as $item) {
      $total += $item['harga'] * $item['qty'];
    }

    // Use database transaction
    DB::beginTransaction();
    try {
      // Create order
      $order = Order::create([
        'user_id' => Auth::id(),
        'tanggal' => now()->toDateString(),
        'total' => $total,
        'bukti_pembayaran' => null,
        'status_pembayaran' => 'sukses', // Simulated payment
      ]);

      // Create order products and update stock
      foreach ($cart as $item) {
        OrderProduct::create([
          'order_id' => $order->id,
          'product_id' => $item['id'],
          'jumlah' => $item['qty'],
          'harga_satuan' => $item['harga'],
        ]);

        // Decrease product stock
        $product = \App\Models\Product::find($item['id']);
        if ($product) {
          $product->stok -= $item['qty'];
          $product->save();
        }
      }

      // Clear cart
      Session::forget('cart');

      DB::commit();

      return redirect()->route('orders.show', $order->id)
        ->with('success', 'Pembayaran berhasil! Pesanan Anda telah dibuat.');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
    }
  }

  /**
   * Display order history for the authenticated user.
   */
  public function orderHistory()
  {
    $orders = Order::where('user_id', Auth::id())
      ->orderBy('created_at', 'desc')
      ->paginate(10);

    return view('orders.index', compact('orders'));
  }

  /**
   * Display order details.
   */
  public function orderDetail($order_id)
  {
    $order = Order::where('user_id', Auth::id())
      ->where('id', $order_id)
      ->with('orderProducts.product')
      ->firstOrFail();

    return view('orders.show', compact('order'));
  }
}
