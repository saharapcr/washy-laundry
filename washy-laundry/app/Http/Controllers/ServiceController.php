<?php

namespace App\Http\Controllers;

use App\Models\{Service, LaundryOrder};
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('admin.layanan', [
            'layanans' => Service::all(),
            'terbaru' => LaundryOrder::with('user', 'detail.layanan')->latest()->take(4)->get(),
        ]);
    }

    public function store(Request $r)
    {
        Service::create($r->validate([
            'nama_layanan' => 'required|string|max:100',
            'harga_perkg' => 'required|integer|min:0',
            'durasi_hari' => 'required|integer|min:1',
        ]));
        return back()->with('ok', 'Layanan ditambahkan.');
    }

    public function update(Request $r, Service $layanan)
    {
        $layanan->update($r->validate([
            'nama_layanan' => 'required|string|max:100',
            'harga_perkg' => 'required|integer|min:0',
            'status_layanan' => 'required|boolean',
        ]));
        return back()->with('ok', 'Layanan diperbarui.');
    }
}
