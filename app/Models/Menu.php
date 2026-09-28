<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'nama_menu',
        'deskripsi',
        'harga',
        'foto',
        'status',
    ];

    public function stok()
    {
        return $this->hasOne(Stok::class, 'id_menu', 'id_menu');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_menu', 'id_menu');
    }

    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && file_exists(public_path($this->foto))) {
            return asset($this->foto);
        }

        if ($this->foto && file_exists(public_path('images/menu/' . $this->foto))) {
            return asset('images/menu/' . $this->foto);
        }

        if ($this->foto && file_exists(public_path('uploads/menu/' . $this->foto))) {
            return asset('uploads/menu/' . $this->foto);
        }

        // fallback default per menu name
        $name = strtolower($this->nama_menu);
        if (str_contains($name, 'mentai') && str_contains($name, 'gyoza')) {
            return asset('images/menu/gyoza_mentai.jpg');
        } elseif (str_contains($name, 'mentai')) {
            return asset('images/menu/dimsum_mentai.jpg');
        } elseif (str_contains($name, 'goreng')) {
            return asset('images/menu/dimsum_goreng.jpg');
        } elseif (str_contains($name, 'keju') || str_contains($name, 'bola')) {
            return asset('images/menu/bola_ayam_keju.jpg');
        }
        return asset('images/menu/dimsum_original.jpg');
    }

    public function getIsAvailableAttribute(): bool
    {
        $stockQty = $this->stok ? $this->stok->jumlah_stok : 0;
        return $this->status === 'tersedia' && $stockQty > 0;
    }
}