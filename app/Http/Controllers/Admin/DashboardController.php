<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan hanya admin yang bisa mengakses
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman Admin!');
        }

        // Mengambil data produk dan total pesanan
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        // Ambil daftar pesanan beserta relasi user, pembayaran, dan item produknya
        $orders = Order::with(['user', 'payment', 'items.product'])->latest()->get();

        return view('admin.dashboard', compact('orders', 'totalProducts', 'totalOrders'));
    }
   public function updateOrderStatus(Request $request, Order $order)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'status' => 'required|in:completed,cancelled', // Diubah dari rejected ke cancelled
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}