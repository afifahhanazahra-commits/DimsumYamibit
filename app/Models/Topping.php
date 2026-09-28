<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    protected $table = 'topping';
    protected $primaryKey = 'id_topping';

    protected $fillable = [
        'nama_topping',
        'harga_tambahan',
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_topping', 'id_topping');
    }

    public function getFormattedHargaAttribute(): string
    {
        if ($this->harga_tambahan == 0) {
            return 'Gratis';
        }
        return '+Rp ' . number_format($this->harga_tambahan, 0, ',', '.');
    }
}