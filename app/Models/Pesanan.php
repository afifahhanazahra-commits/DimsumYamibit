<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'kode_pesanan',
        'id_pelanggan',
        'tanggal_pesanan',
        'metode_pengiriman',
        'bukti_qris',
        'status_pembayaran',
        'status_pesanan',
        'total_harga',
        'link_wa',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getBuktiQrisUrlAttribute(): ?string
    {
        if (!$this->bukti_qris) {
            return null;
        }
        if (str_starts_with($this->bukti_qris, 'http')) {
            return $this->bukti_qris;
        }
        return asset($this->bukti_qris);
    }

    public function getStatusPembayaranBadgeAttribute(): array
    {
        return match ($this->status_pembayaran) {
            'valid' => ['label' => 'Pembayaran Valid', 'class' => 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border-emerald-300 dark:border-emerald-800'],
            'ditolak' => ['label' => 'Bukti Ditolak', 'class' => 'bg-rose-500/15 text-rose-600 dark:text-rose-400 border-rose-300 dark:border-rose-800'],
            default => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-amber-500/15 text-amber-600 dark:text-amber-400 border-amber-300 dark:border-amber-800'],
        };
    }

    public function getStatusPesananBadgeAttribute(): array
    {
        return match ($this->status_pesanan) {
            'menunggu_bayar' => ['label' => 'Menunggu Bayar / Verifikasi', 'class' => 'bg-amber-500/15 text-amber-600 dark:text-amber-400 border-amber-300 dark:border-amber-800'],
            'diproses' => ['label' => 'Sedang Dikukus / Dapur', 'class' => 'bg-blue-500/15 text-blue-600 dark:text-blue-400 border-blue-300 dark:border-blue-800'],
            'siap_diambil' => ['label' => 'Siap Diambil / Panggil Ojol', 'class' => 'bg-purple-500/15 text-purple-600 dark:text-purple-400 border-purple-300 dark:border-purple-800'],
            'selesai' => ['label' => 'Selesai', 'class' => 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border-emerald-300 dark:border-emerald-800'],
            default => ['label' => ucfirst(str_replace('_', ' ', $this->status_pesanan)), 'class' => 'bg-gray-500/15 text-gray-600 dark:text-gray-400 border-gray-300 dark:border-gray-800'],
        };
    }

    public function generateWaLink(): string
    {
        $phone = '628990745953'; 
        $nama = $this->pelanggan ? $this->pelanggan->nama : 'Pelanggan';
        $metode = $this->metode_pengiriman === 'pickup' ? 'Ambil di Toko (Pickup)' : 'Ojek Online Mandiri';
        
        $itemsText = [];
        foreach ($this->detailPesanan as $detail) {
            $menuName = $detail->menu ? $detail->menu->nama_menu : 'Menu';
            $toppingName = $detail->topping ? ' (+ ' . $detail->topping->nama_topping . ')' : '';
            $itemsText[] = "• {$detail->jumlah}x {$menuName}{$toppingName} (Rp " . number_format($detail->subtotal, 0, ',', '.') . ")";
        }
        $rincian = implode("\n", $itemsText);

        $msg = "Halo *Dimsum Yamibit*, saya ingin konfirmasi pesanan:\n\n"
             . "🔖 *Kode Pesanan:* #{$this->kode_pesanan}\n"
             . "👤 *Nama Pemesan:* {$nama}\n"
             . "🛵 *Metode:* {$metode}\n"
             . "💰 *Total:* Rp " . number_format($this->total_harga, 0, ',', '.') . "\n\n"
             . "📋 *Rincian Item:*\n{$rincian}\n\n"
             . "Mohon info jika pesanan sudah mulai dikukus / siap diambil. Terima kasih! 🙏";

        return 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . rawurlencode($msg);
    }
}