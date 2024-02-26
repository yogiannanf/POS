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