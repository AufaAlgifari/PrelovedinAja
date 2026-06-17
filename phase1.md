Saya sedang mengembangkan marketplace Laravel bernama Preloved.in Aja. Proyek menggunakan Laravel, MySQL, Blade, dan Tailwind CSS.

Saya ingin mengimplementasikan Tahap 1 integrasi Midtrans dengan spesifikasi berikut:

Tujuan:

* Menambahkan tombol "Beli Sekarang" pada halaman detail produk.
* Menyiapkan alur checkout langsung tanpa melalui keranjang.
* Mempersiapkan struktur database agar kompatibel dengan Midtrans pada tahap berikutnya.

Kondisi saat ini:

* Sudah terdapat tabel products.
* Sudah terdapat tabel transactions dengan kolom:

  * id
  * user_id
  * cart_id
  * transaction_id
  * order_id_midtrans
  * amount
  * status
  * payment_type
  * snap_token
* Saat ini transaksi hanya berelasi dengan cart.

Yang harus dikerjakan:

1. Buat migration baru untuk menambahkan kolom:

   * product_id (nullable foreign key ke products)

2. Update model Transaction:

   * Tambahkan relasi belongsTo Product.
   * Pastikan relasi User tetap berjalan.

3. Update model Product:

   * Tambahkan relasi hasMany Transaction.

4. Pada halaman detail produk:

   * Tambahkan tombol:

     * Tambah Keranjang
     * Beli Sekarang

5. Buat route baru:

   * GET /checkout/{product}

6. Buat CheckoutController:

   * method index(Product $product)
   * hanya menampilkan halaman checkout sederhana.

7. Buat halaman checkout.blade.php yang menampilkan:

   * Nama produk
   * Harga produk
   * Kondisi produk
   * Tombol "Lanjut ke Pembayaran"

8. Gunakan middleware auth sehingga hanya user login yang dapat mengakses checkout.

9. Ikuti best practice Laravel:

   * Gunakan route model binding.
   * Gunakan foreign key constraint.
   * Gunakan type hinting.
   * Gunakan coding style Laravel terbaru.

Output yang saya inginkan:

* Migration lengkap.
* Route lengkap.
* Controller lengkap.
* Perubahan pada model Product.
* Perubahan pada model Transaction.
* Contoh Blade detail produk.
* File checkout.blade.php lengkap.

Jangan implementasikan Midtrans dulu. Fokus hanya pada persiapan checkout dan tombol Beli Sekarang.
