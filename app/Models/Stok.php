<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok';
    protected $primaryKey = 'id_stok';
    public $timestamps = false;

    protected $fillable = [
        'id_menu',
        'jumlah_stok',
        'update_terakhir',
    ];

    protected $casts = [
        'update_terakhir' => 'datetime',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    public function getStatusBadgeAttribute(): array
    {
        if ($this->jumlah_stok <= 0) {
            return ['label' => 'Habis', 'class' => 'bg-rose-500/15 text-rose-600 dark:text-rose-400 border-rose-200 dark:border-rose-800'];
        } elseif ($this->jumlah_stok <= 10) {
            return ['label' => 'Menipis (' . $this->jumlah_stok . ')', 'class' => 'bg-amber-500/15 text-amber-600 dark:text-amber-400 border-amber-200 dark:border-amber-800'];
        }
        return ['label' => 'Aman (' . $this->jumlah_stok . ')', 'class' => 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800'];
    }
}