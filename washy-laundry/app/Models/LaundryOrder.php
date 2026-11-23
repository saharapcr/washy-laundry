<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaundryOrder extends Model
{
    protected $fillable = [
        'user_id', 'kode', 'total_harga', 'tanggal_pesanan', 'estimasi_selesai',
        'status_pesanan', 'jadwal_jemput', 'alamat_jemput', 'catatan', 'kurir',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'date',
        'estimasi_selesai' => 'datetime',
        'jadwal_jemput' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function detail() { return $this->hasOne(OrderDetail::class, 'laundry_order_id'); }
    public function pembayaran() { return $this->hasOne(Payment::class, 'laundry_order_id'); }
}
