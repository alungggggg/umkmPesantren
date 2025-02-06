<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class umkmModel extends Model
{
    use HasFactory;
    protected $table = 'umkm';
    public $timestamps = false;
    protected $fillable = [
        'namaUmkm',
        'image',
        'description',
        'category',
        'whatsapp',
        'maps',
        'facebook',
        'instagram',
        'tiktok',
    ];

    public function menu(): HasMany
    {
        return $this->hasMany(menuModel::class, "umkm_id", "id");
    }
}
