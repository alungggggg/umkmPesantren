<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menuModel extends Model
{
    use HasFactory;
    protected $table = 'daftar_menu';
    public $timestamps = false;
    protected $fillable = [
        'umkm_id',
        'namaMakanan',
        'image',
        'harga',
    ];
}
