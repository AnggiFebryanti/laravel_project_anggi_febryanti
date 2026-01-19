<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function index()
  {
    // Ambil data user yang sedang login
    $user = Auth::user();

    // Return view dashboard dengan data user
    return view('dashboard.index', compact('user'));
  }
}
