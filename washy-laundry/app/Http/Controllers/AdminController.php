<?php

namespace App\Http\Controllers;

use App\Models\{LaundryOrder, Payment, User};
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function terbaru()
    {
        return LaundryOrder::with('user', 'detail.layanan')->latest()->take(4)->get();
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'hariIni' => LaundryOrder::whereDate('tanggal_pesanan', today())->count(),
            'diproses' => LaundryOrder::where('status_pesanan', 'Sedang dicuci')->count(),
            'selesai' => LaundryOrder::where('status_pesanan', 'Selesai')->count(),
            'pelanggan' => User::where('role', 'pelanggan')->count(),
            'terbaru' => $this->terbaru(),
        ]);
    }

    public function pesanan()
    {
        return view('admin.pesanan', [
            'masuk' => LaundryOrder::where('status_pesanan', 'Diterima')->count(),
            'diproses' => LaundryOrder::where('status_pesanan', 'Sedang dicuci')->count(),
            'siap' => LaundryOrder::where('status_pesanan', 'Siap diambil')->count(),
            'selesai' => LaundryOrder::where('status_pesanan', 'Selesai')->count(),
            'pesanans' => LaundryOrder::with('user', 'detail.layanan')->latest()->get(),
        ]);
    }

    public function detail(LaundryOrder $pesanan)
    {
        $pesanan->load('user', 'detail.layanan', 'pembayaran');
        return view('admin.detail', [
            'pesanan' => $pesanan,
            'status' => ['Diterima', 'Sedang dicuci', 'Siap diambil', 'Selesai'],
            'terbaru' => $this->terbaru(),
        ]);
    }

    public function updateStatus(Request $r, LaundryOrder $pesanan)
    {
        $d = $r->validate(['status_pesanan' => 'required|in:Diterima,Sedang dicuci,Siap diambil,Selesai', 'kurir' => 'nullable|string']);
        $pesanan->update($d);
        return back()->with('ok', 'Status pesanan diperbarui.');
    }

    public function pembayaran()
    {
        return view('admin.pembayaran', [
            'hariIni' => Payment::where('status_pembayaran', 'Berhasil')->whereDate('tanggal_pembayaran', today())->sum('jumlah_bayar'),
            'menunggu' => Payment::where('status_pembayaran', 'Menunggu')->count(),
            'berhasil' => Payment::where('status_pembayaran', 'Berhasil')->count(),
            'refund' => Payment::where('status_pembayaran', 'Refund')->count(),
            'pembayarans' => Payment::with('pesanan.user')->latest()->get(),
        ]);
    }

    public function konfirmasi(Payment $pembayaran)
    {
        $pembayaran->update(['status_pembayaran' => 'Berhasil', 'tanggal_pembayaran' => today()]);
        return back()->with('ok', 'Pembayaran dikonfirmasi.');
    }

    public function pelanggan()
    {
        $users = User::where('role', 'pelanggan')->withCount('pesanans')->get();
        return view('admin.pelanggan', [
            'users' => $users,
            'total' => $users->count(),
            'aktif' => User::where('role', 'pelanggan')->whereHas('pesanans', fn($q) => $q->whereMonth('tanggal_pesanan', now()->month))->count(),
            'baru' => User::where('role', 'pelanggan')->whereMonth('created_at', now()->month)->count(),
            'rata' => $users->count() ? round($users->sum('pesanans_count') / $users->count(), 1) : 0,
            'terbaru' => $this->terbaru(),
        ]);
    }
}
