<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['nama_layanan', 'deskripsi', 'harga_perkg', 'durasi_hari', 'status_layanan'];
}
