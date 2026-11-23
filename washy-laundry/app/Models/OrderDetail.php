<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['laundry_order_id', 'service_id', 'berat_kg', 'harga_perkg', 'subtotal'];

    public function layanan()
    {return $this->belongsTo(Service::class, 'service_id');}
}
