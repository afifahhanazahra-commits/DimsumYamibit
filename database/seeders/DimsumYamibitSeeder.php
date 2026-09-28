<?php

namespace Database\Seeders;

use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Stok;
use App\Models\Topping;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DimsumYamibitSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Menus & Initial Stock
        $menuList = [
            [
                'nama_menu' => 'Dimsum Original',
                'deskripsi' => 'Dimsum ayam & udang lembut kukus disajikan dengan chili oil gurih pedas.',
                'harga' => 15000,
                'stok' => 50,
                'foto' => 'images/menu/original-personal.jpg',
            ],
            [
                'nama_menu' => 'Dimsum Mentai',
                'deskripsi' => 'Dimsum ayam udang dengan siraman saus mentai creamy torched khas Yamibit.',
                'harga' => 18000,
                'stok' => 35,
                'foto' => 'images/menu/dimsum-goreng-mentai.jpg',
            ],
            [
                'nama_menu' => 'Dimsum Goreng',
                'deskripsi' => 'Dimsum goreng renyah di luar, lembut di dalam dengan saus bangkok manis pedas.',
                'harga' => 16000,
                'stok' => 30,
                'foto' => 'images/menu/dimsum-goreng-keju.jpg',
            ],
            [
                'nama_menu' => 'Gyoza Mentai',
                'deskripsi' => 'Pangsit gyoza khas Jepang dengan saus mentai bakar spesial.',
                'harga' => 20000,
                'stok' => 25,
                'foto' => 'images/menu/gyoza-goreng-mentai.jpg',
            ],
            [
                'nama_menu' => 'Bola Ayam Keju',
                'deskripsi' => 'Bola olahan daging ayam dengan isian keju mozarella lumer dan saus bolognese.',
                'harga' => 17000,
                'stok' => 20,
                'foto' => 'images/menu/bola-ayam-keju.jpg',
            ],
            [
                'nama_menu' => 'Dimsum Nori (Isi 6)',
                'deskripsi' => 'Dimsum ayam berbalut rumput laut nori lezat isi 6 pcs. Free 1 chili oil.',
                'harga' => 27000,
                'stok' => 25,
                'foto' => 'images/menu/nori-personal.jpg',
            ],
            [
                'nama_menu' => 'Dimsum Mix (Isi 6)',
                'deskripsi' => 'Kombinasi aneka varian dimsum lezat isi 6 pcs. Free 1 chili oil.',
                'harga' => 29000,
                'stok' => 25,
                'foto' => 'images/menu/mix-personal.jpg',
            ],
            [
                'nama_menu' => 'Dimsum Cheese (Isi 6)',
                'deskripsi' => 'Dimsum ayam dengan topping keju lumer gurih isi 6 pcs. Free 1 chili oil.',
                'harga' => 29000,
                'stok' => 25,
                'foto' => 'images/menu/cheese-personal.jpg',
            ],
            [
                'nama_menu' => 'Dimsum Platter',
                'deskripsi' => '6 dimsum mentai, 4 dimsum goreng, 3 gyoza. Free 2 chili oil & 2 saus bangkok.',
                'harga' => 57000,
                'stok' => 20,
                'foto' => 'images/menu/dimsum-platter.jpg',
            ],
            [
                'nama_menu' => 'Dimsum Platter Mentai',
                'deskripsi' => '6 dimsum mentai, 4 dimsum goreng, 3 gyoza dengan lumuran saus mentai creamy.',
                'harga' => 62000,
                'stok' => 20,
                'foto' => 'images/menu/dimsum-platter-mentai.jpg',
            ],
            [
                'nama_menu' => 'Dimsum Goreng Keju',
                'deskripsi' => 'Dimsum goreng crispy isi 5 pcs dengan lelehan keju lumer.',
                'harga' => 26000,
                'stok' => 25,
                'foto' => 'images/menu/dimsum-goreng-keju.jpg',
            ],
            [
                'nama_menu' => 'Original (Party Isi 16)',
                'deskripsi' => 'Dimsum ayam original porsi besar kemasan foil tray isi 16 pcs. Free 2 chili oil.',
                'harga' => 57000,
                'stok' => 20,
                'foto' => 'images/menu/original-party.jpg',
            ],
            [
                'nama_menu' => 'Nori (Party Isi 16)',
                'deskripsi' => 'Dimsum nori porsi party isi 16 pcs dengan rasa gurih khas rumput laut. Free 2 chili oil.',
                'harga' => 72000,
                'stok' => 15,
                'foto' => 'images/menu/nori-party.jpg',
            ],
            [
                'nama_menu' => 'Mix (Party Isi 16)',
                'deskripsi' => 'Kombinasi dimsum aneka varian porsi party isi 16 pcs. Free 2 chili oil.',
                'harga' => 77000,
                'stok' => 15,
                'foto' => 'images/menu/mix-party.jpg',
            ],
            [
                'nama_menu' => 'Cheese (Party Isi 16)',
                'deskripsi' => 'Dimsum keju panggang porsi party isi 16 pcs. Free 2 chili oil.',
                'harga' => 80000,
                'stok' => 15,
                'foto' => 'images/menu/cheese-party.jpg',
            ],
        ];

        $createdMenus = [];
        foreach ($menuList as $item) {
            $menu = Menu::updateOrCreate(
                ['nama_menu' => $item['nama_menu']],
                [
                    'deskripsi' => $item['deskripsi'],
                    'harga' => $item['harga'],
                    'status' => 'tersedia',
                    'foto' => $item['foto'],
                ]
            );
            $createdMenus[] = $menu;

            Stok::updateOrCreate(
                ['id_menu' => $menu->id_menu],
                [
                    'jumlah_stok' => $item['stok'],
                    'update_terakhir' => now(),
                ]
            );
        }

        // 2. Seed Toppings
        $toppings = [
            ['nama_topping' => 'Saus Bangkok', 'harga_tambahan' => 3000],
            ['nama_topping' => 'Mentai', 'harga_tambahan' => 5000],
            ['nama_topping' => 'Chili Oil', 'harga_tambahan' => 2000],
            ['nama_topping' => 'Bolognese', 'harga_tambahan' => 4000],
        ];

        $createdToppings = [];
        foreach ($toppings as $top) {
            $createdToppings[] = Topping::updateOrCreate(
                ['nama_topping' => $top['nama_topping']],
                ['harga_tambahan' => $top['harga_tambahan']]
            );
        }

        // 3. Seed Admin Account
        User::updateOrCreate(
            ['email' => 'admin@dimsumyamibit.com'],
            [
                'name' => 'Admin Dimsum Yamibit',
                'password' => Hash::make('admin123'),
            ]
        );

        // 4. Seed Sample Orders & Customers (for rich analytics & reporting)
        $sampleCustomers = [
            ['nama' => 'Fatansyah', 'no_hp' => '081234567890', 'alamat' => 'Perumahan Arumsari Blok C No. 12, Talun, Cirebon'],
            ['nama' => 'Aisha Varhana', 'no_hp' => '085712345678', 'alamat' => 'Jl. Pemuda No. 45, Kesambi, Cirebon'],
            ['nama' => 'Sofi Nuraini', 'no_hp' => '082198765432', 'alamat' => 'Jl. Dr. Cipto Mangunkusumo No. 88, Cirebon'],
            ['nama' => 'Chintya Aura Berliany', 'no_hp' => '081399887766', 'alamat' => 'Perum Bumi Cirebon Lestari No. 15, Harjamukti'],
            ['nama' => 'Afifah Hana Zahra', 'no_hp' => '08990745953', 'alamat' => 'Jl. Jembatan Merah No. 02, Kecomberan, Talun'],
        ];

        if (Pesanan::count() === 0) {
            foreach ($sampleCustomers as $idx => $custData) {
            $pelanggan = Pelanggan::create($custData);

            $date = Carbon::now()->subDays(4 - $idx)->setTime(rand(11, 20), rand(10, 50));
            $kode = 'YAMI-' . $date->format('Ymd') . '-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT);
            $metode = $idx % 2 === 0 ? 'pickup' : 'ojol';

            $statusPembayaran = $idx === 4 ? 'menunggu' : ($idx === 3 ? 'ditolak' : 'valid');
            $statusPesanan = match ($statusPembayaran) {
                'menunggu' => 'menunggu_bayar',
                'ditolak' => 'menunggu_bayar',
                default => ($idx === 0 ? 'selesai' : ($idx === 1 ? 'siap_diambil' : 'diproses')),
            };

            $pesanan = Pesanan::create([
                'kode_pesanan' => $kode,
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'tanggal_pesanan' => $date,
                'metode_pengiriman' => $metode,
                'bukti_qris' => 'images/sample_receipt.png',
                'status_pembayaran' => $statusPembayaran,
                'status_pesanan' => $statusPesanan,
                'total_harga' => 0,
                'link_wa' => '',
            ]);

            // Add detail items
            $total = 0;
            $selectedMenu = $createdMenus[$idx % count($createdMenus)];
            $selectedTopping = $idx % 2 === 0 ? $createdToppings[$idx % count($createdToppings)] : null;
            $qty = rand(1, 3);
            $itemSubtotal = ($selectedMenu->harga + ($selectedTopping ? $selectedTopping->harga_tambahan : 0)) * $qty;

            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_menu' => $selectedMenu->id_menu,
                'id_topping' => $selectedTopping ? $selectedTopping->id_topping : null,
                'jumlah' => $qty,
                'subtotal' => $itemSubtotal,
            ]);

            $total += $itemSubtotal;

            // Extra item for some orders
            if ($idx % 2 === 1) {
                $extraMenu = $createdMenus[($idx + 2) % count($createdMenus)];
                $extraSubtotal = $extraMenu->harga * 1;
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_menu' => $extraMenu->id_menu,
                    'id_topping' => null,
                    'jumlah' => 1,
                    'subtotal' => $extraSubtotal,
                ]);
                $total += $extraSubtotal;
            }

            $pesanan->update([
                'total_harga' => $total,
                'link_wa' => $pesanan->generateWaLink(),
            ]);
        }
        }
    }
}