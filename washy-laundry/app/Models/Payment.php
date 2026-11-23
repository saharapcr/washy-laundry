<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['laundry_order_id', 'jumlah_bayar', 'metode_pembayaran', 'status_pembayaran', 'tanggal_pembayaran'];

    public function pesanan()
    {return $this->belongsTo(LaundryOrder::class, 'laundry_order_id');}
}
