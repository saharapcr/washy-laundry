<?php

namespace App\Http\Controllers;

use App\Models\{Service, LaundryOrder, OrderDetail, Payment};
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private function saya()
    {
        return LaundryOrder::with('detail.layanan')->where('user_id', auth()->id());
    }

    public function beranda()
    {
        $total = LaundryOrder::where('user_id', auth()->id())->sum('total_harga');
        return view('customer.beranda', [
            'aktif' => LaundryOrder::where('user_id', auth()->id())->where('status_pesanan', '!=', 'Selesai')->count(),
            'selesai' => LaundryOrder::where('user_id', auth()->id())->where('status_pesanan', 'Selesai')
                ->whereMonth('tanggal_pesanan', now()->month)->count(),
            'poin' => intdiv($total, 1000),
            'total' => $total,
            'terbaru' => $this->saya()->latest()->take(4)->get(),
        ]);
    }

    public function kalkulator(Request $r)
    {
        $layanans = Service::where('status_layanan', true)->get();
        $layanan = $layanans->firstWhere('id', $r->layanan_id) ?? $layanans->first();
        $berat = (float) ($r->berat ?? 0);
        return view('customer.kalkulator', [
            'layanans' => $layanans,
            'layanan' => $layanan,
            'berat' => $berat,
            'estimasi' => $layanan ? (int) round($layanan->harga_perkg * $berat) : 0,
            'terbaru' => $this->saya()->latest()->take(4)->get(),
        ]);
    }

    public function buat()
    {
        return view('customer.pesanan', ['layanans' => Service::where('status_layanan', true)->get()]);
    }

    public function simpan(Request $r)
    {
        $d = $r->validate([
            'layanan_id' => 'required|exists:services,id',
            'berat_kg' => 'required|numeric|min:0.5',
            'jadwal_jemput' => 'required|date',
            'alamat_jemput' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $layanan = Service::findOrFail($d['layanan_id']);
        $total = (int) round($layanan->harga_perkg * $d['berat_kg']);

        $o = LaundryOrder::create([
            'user_id' => auth()->id(),
            'kode' => 'WSH-' . str_pad((LaundryOrder::max('id') ?? 0) + 1 + 244, 4, '0', STR_PAD_LEFT),
            'total_harga' => $total,
            'tanggal_pesanan' => now(),
            'estimasi_selesai' => now()->addDays($layanan->durasi_hari),
            'status_pesanan' => 'Diterima',
            'jadwal_jemput' => $d['jadwal_jemput'],
            'alamat_jemput' => $d['alamat_jemput'],
            'catatan' => $d['catatan'] ?? null,
        ]);
        OrderDetail::create(['laundry_order_id' => $o->id, 'service_id' => $layanan->id,
            'berat_kg' => $d['berat_kg'], 'harga_perkg' => $layanan->harga_perkg, 'subtotal' => $total]);
        Payment::create(['laundry_order_id' => $o->id, 'jumlah_bayar' => $total]);

        return redirect()->route('lacak', ['id' => $o->id])->with('ok', 'Pesanan berhasil dibuat!');
    }

    public function lacak(Request $r)
    {
        $pesanan = $r->id
            ? $this->saya()->find($r->id)
            : ($this->saya()->where('status_pesanan', '!=', 'Selesai')->latest()->first() ?? $this->saya()->latest()->first());

        return view('customer.lacak', [
            'pesanan' => $pesanan,
            'tahap' => ['Diterima', 'Sedang dicuci', 'Siap diambil', 'Selesai'],
            'terbaru' => $this->saya()->latest()->take(4)->get(),
        ]);
    }

    public function riwayat()
    {
        return view('customer.riwayat', ['pesanans' => $this->saya()->latest()->get()]);
    }

    public function profil()
    {
        return view('customer.profil', ['terbaru' => $this->saya()->latest()->take(4)->get()]);
    }

    public function updateProfil(Request $r)
    {
        $d = $r->validate(['name' => 'required|string|max:100', 'no_telepon' => 'nullable|string|max:20', 'alamat' => 'nullable|string']);
        auth()->user()->update($d);
        return back()->with('ok', 'Profil berhasil diperbarui.');
    }
}
