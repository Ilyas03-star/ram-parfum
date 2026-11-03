<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'shipping_address' => 'required',
        ]);

        $variant = ProductVariant::with('product')->findOrFail($request->variant_id);

        // Buat Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'RAM-' . time(),
            'total_amount' => $variant->price,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
        ]);

        // Buat Order Item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $variant->product_id,
            'quantity' => 1,
            'price' => $variant->price,
        ]);

        return view('order.payment', compact('order'));
    }

    public function uploadProof(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('proof_image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/payments'), $fileName);

        Payment::create([
            'order_id' => $request->order_id,
            'proof_image' => 'uploads/payments/' . $fileName,
            'status' => 'pending',
        ]);

        Order::where('id', $request->order_id)->update(['status' => 'waiting_confirmation']);

        return redirect()->route('home')->with('success', 'Bukti pembayaran berhasil diupload. Admin akan segera memverifikasi pesanan Anda!');
    }
    // Menampilkan riwayat transaksi / keranjang pesanan pembeli
    public function myOrders()
    {
        $orders = Order::with(['items.product', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('order.my-orders', compact('orders'));
    }

    // Pembeli mengonfirmasi pesanan selesai (barang sudah sampai)
    public function markAsComplete(Order $order)
    {
        // Pastikan order milik user yang sedang login
        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Akses tidak sah!');
        }

        $order->update([
            'status' => 'completed',
        ]);

        return redirect()->back()->with('success', 'Pesanan dikonfirmasi selesai. Terima kasih telah berbelanja di RAM Parfum!');
    }
}