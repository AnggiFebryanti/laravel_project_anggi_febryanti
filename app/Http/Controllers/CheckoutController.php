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

    return view('user.checkout', compact('cart'));
  }

  // Proses checkout
  public function process(Request $request)
  {
    $cart = Session::get('cart', []);
    if (!$cart || count($cart) === 0) {
      return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
    }

    $validated = $request->validate([
      'nama' => 'required|string|max:255',
      'alamat' => 'required|string',
      'telepon' => 'required|string|max:20',
      'metode' => 'required|string',
    ]);
    // Untuk sekarang kita anggap sukses
    Session::forget('cart'); // Kosongkan keranjang setelah checkout
    return redirect()->route('checkout.index')->with('success', 'Pesanan berhasil
diproses! Terima kasih sudah berbelanja.');
  }
}
