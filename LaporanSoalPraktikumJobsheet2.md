# **Laporan S Soal Praktikum Jobsheet 02 Routing, Controller dan View**
---

## Nama  : Yogianna Nur Febrianti
## Kelas : TI 2F
## Absen : 27

**SOAL PRAKTIKUM**

1. Jalankan Langkah-langkah Praktikum pada jobsheet di atas. Lakukan sinkronisasi
perubahan pada project PWL_2024 ke Github.

<img src = img/soal1.png>

2. Buatlah project baru dengan nama POS. Project ini merupakan sebuah aplikasi Point of Sales yang digunakan untuk membantu penjualan.

<img src = img/soal2run.png>

<img src = img/soal2runlanjutan.png>

<img src = img/soal2github.png>

3. Buatlah beberapa route, controller, dan view sesuai dengan ketentuan sebagai berikut.

| | |
|---|-----|
| 1 | Halaman Home |
|   | Menampilkan halaman awal website|
| 2 | Halaman Products |
| | Menampilkan daftar product (route prefix) |
| | /category/food-beverage |
| | /category/beauty-health |
| | /category/home-care |
| | /category/baby-kid |
| 3 | Halaman User |
| | Menampilkan profil pengguna (route param) |
| | /user/{id}/name/{name} |
| 4 | Halaman Penjualan |
| | Menampilkan halaman transaksi POS 

Jawab :
- Membuat Controller : Pos Controller

<img src = img/soal3_1.png>

- Membuat Folder Pos di resources : views : pos

<img src = img/soal3_2.png>

- POSController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class POSController extends Controller
{
    public function home()
    {
        return view('pos.home');
    }
    public function products()
    {
        return view('pos.products');
    }
    public function productsCategory($category)
    {
        return view('pos.productsCategory', ['category' => $category]);
    }
    public function user($id, $name)
    {
        return view('pos.userProfil', ['id' => $id, 'name' => $name]);
    }
    public function sales()
    {
        return view('pos.sales');
    }
    public function processSale(Request $request)
    {

    // Mendapatkan data produk dan jumlah dari formulir penjualan
    $product = $request->input('product');
    $kuantitas = $request->input('kuantitas');

    // Contoh: Harga produk (gantilah dengan data sebenarnya)
    $hargaPos = [
        'mie-instan' => 3000,
        'minuman-soda' => 3500,
        'kacang-almond' => 8000,
        'sabun-mandi' => 3000,
        'krim-pemutih wajah' => 70000,
        'suplemen-vitamin' => 100000,
        'pembersih-lantai' => 20000,
        'wangian-ruangan' => 15000,
        'lampu-led' => 25000,
        'pakaian-bayi' => 200000,
        'mainan-anak' => 70000,
        'susu-formula' => 350000,
    ];

    // Memastikan produk yang dipilih ada dalam array harga
    if (array_key_exists($product, $hargaPos)) {
    // Menghitung total pembelian
    $totalJumlah = $kuantitas * $hargaPos[$product];
    // Menyimpan data penjualan ke dalam array sementara (gantilah dengan penyimpanan ke database atau sistem lainnya)
    $saleData = [
        'product' => $product,
        'kuantitas' => $kuantitas,
        'totalJumlah' => $totalJumlah,
        'waktu' => now(),
    ];
    // Menyimpan data penjualan ke dalam sesi untuk digunakan di halaman terima kasih
    Session::put('saleData', $saleData);
    // Redirect atau tampilkan halaman terima kasih atau struk pembelian
        return view('pos.salesThankyou', ['saleData' => $saleData]);
    } else {
    // Handle jika produk tidak ditemukan
        return redirect()->route('pos.sales')->with('error', 'Produk tidak ditemukan.');
    }   
    }
}
```

- home.blade.php
```php
<html>
    <head>
        <title>Halaman Utama - POS</title>
    </head>
    <body>
        <h1>Selamat Datang di Supermarket POS</h1>
    </body>
</html>
```

- products.blade.php
```php
<html>
    <head>
        <title>Daftar Produk - POS</title>
    </head>
    <body>
        <h1>Daftar Produk</h1>
        <ul>
        <li><a href="{{ url('/category/food-beverage') }}">Kategori Makanan & Minuman</a></li>
        <li><a href="{{ url('/category/beauty-health') }}">Kategori Kecantikan & Kesehatan</a></li>
        <li><a href="{{ url('/category/home-care') }}">Kategori Perawatan Rumah</a></li>
        <li><a href="{{ url('/category/baby-kid') }}">Kategori Bayi & Anak-anak</a></li>
        </ul>
    </body>
</html>
```

- productsCategory.blade.php
```php
<html>
    <head>
        <title>Daftar Produk Berdasarkan Kategori - POS</title>
    </head>
    <body>
        <h1>Daftar Produk untuk Kategori: {{ $category }}</h1>
    <ul>
        @if ($category == 'food-beverage')
        <li>Mie Instan</li>
        <li>Minuman Soda</li>
        <li>Kacang Almond</li>
        @elseif ($category == 'beauty-health')
        <li>Sabun Mandi</li>
        <li>Krim Pemutih Wajah</li>
        <li>Suplemen Vitamin</li>
        @elseif ($category == 'home-care')
        <li>Pembersih Lantai</li>
        <li>Wangian Ruangan</li>
        <li>Lampu LED</li>
        @elseif ($category == 'baby-kid')
        <li>Pakaian Bayi</li>
        <li>Mainan Anak</li>
        <li>Susu Formula</li>
        @else
        <li>Belum ada produk untuk kategori ini</li>
        @endif
    </ul>
    </body>
</html>
```

- userProfil.blade.php
```php
<!-- resources/views/pos/user-profile.blade.php -->
<html>
    <head>
        <title>Profil Pengguna - POS</title>
    </head>
    <body>
        <h1>Profil Pengguna</h1>
        <p>ID Pengguna: {{ $id }}</p>
        <p>Nama Pengguna: {{ $name }}</p>
    </body>
</html>
```

- sales.blade.php
```php
<html>
    <head>
        <title>Halaman Penjualan - POS</title>
    </head>
    <body>
        <h1>Halaman Transaksi POS</h1>
        <form action="{{ route('process.sale') }}" method="post">
        @csrf
        <label for="product">Pilih Produk:</label>
        <select name="product" id="product">
            <option value="mie-instan">Mie Instan</option>
            <option value="minuman-soda">Minuman Soda</option>
            <option value="kacang-almond">Kacang Almond</option>
            <option value="sabun-mandi">Sabun Mandi</option>
            <option value="krim-pemutih wajah">Krim Pemutih Wajah</option>
            <option value="suplemen-vitamin">Suplemen Vitamin</option>
            <option value="pembersih-lantai">Pembersih Lantai</option>
            <option value="wangian-ruangan">Wangian Ruangan</option>
            <option value="lampu-led">Lampu LED</option>
            <option value="pakaian-bayi">Pakaian Bayi</option>
            <option value="mainan-anak">Mainan Anak</option>
            <option value="susu-formula">Susu Formula</option>
        </select>
        <label for="kuantitas">Jumlah:</label>
        <input type="number" name="kuantitas" id="kuantitas" min="1" value="1">
        <button type="submit">Proses Penjualan</button>
    </form>
        <p>Silakan pilih produk dan masukkan jumlahnya untuk memulai transaksi.</p>
    </body>
</html>
```
- salesThankyou.blade.php
```php
<html>
    <head>
        <title>Terima Kasih atas Pembelian Anda - POS</title>
    </head>
    <body>
        <h1>Terima Kasih sudah berbelanja di Supermarket POS </h1>
        <p>Detail Pembelian:</p>
        <ul>
            <li>Produk: {{ $saleData['product'] }}</li>
            <li>Jumlah: {{ $saleData['kuantitas'] }}</li>
            <li>Total Pembelian: {{ $saleData['totalJumlah'] }}</li>
        </ul>
    </body>
</html>
```

    1. Menampilkan halaman awal website :

<img src = img/soal3_3.png>

    2. Menampilkan daftar product

<img src = img/soal3_4.png>

<img src = img/soal3_5.png>

    3. Menampilkan profil pengguna

<img src = img/soal3_6.png>

    4. Menampilkan halaman transaksi POS

<img src = img/soal3_7.png>

<img src = img/soal3_8.png>

4. Route tersebut menjalankan fungsi pada Controller yang berbeda di setiap halaman.

5. Fungsi pada Controller akan memanggil view sesuai halaman yang akan ditampilkan.

6. Simpan setiap perubahan yang dilakukan pada project POS pada Git, sinkronisasi perubahan ke Github.

<img src = img/soal5.png>