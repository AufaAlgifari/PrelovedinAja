Saya sedang mengembangkan marketplace Laravel bernama Preloved.in Aja menggunakan Laravel, Blade, Tailwind CSS, dan MySQL.

Tahap 1 sudah selesai:

* Tombol "Beli Sekarang" sudah ada.
* Halaman checkout sudah ada.
* Tabel transactions sudah tersedia.
* Relasi Product dan Transaction sudah tersedia.

Sekarang saya ingin mengimplementasikan Tahap 2 yaitu integrasi Midtrans Snap Payment.

Tujuan:

* Membuat transaksi baru ketika user menekan tombol pembayaran.
* Menghasilkan Snap Token dari Midtrans.
* Menyimpan Snap Token ke database.
* Menampilkan popup pembayaran Midtrans.

Kondisi database saat ini:

Tabel transactions:

* id
* user_id
* product_id
* transaction_id
* order_id_midtrans
* amount
* status
* payment_type
* snap_token

Status yang digunakan:

* pending
* success
* failed
* expired

Yang harus dikerjakan:

1. Install dan konfigurasi Midtrans PHP SDK.

2. Buat file konfigurasi Midtrans yang mengambil data dari .env:

   * MIDTRANS_SERVER_KEY
   * MIDTRANS_CLIENT_KEY
   * MIDTRANS_IS_PRODUCTION

3. Buat method processPayment() pada CheckoutController.

4. Saat user menekan tombol "Lanjut ke Pembayaran":

   * Buat record transaction baru.
   * Generate order_id unik.
   * Simpan status = pending.
   * Simpan amount sesuai harga produk.

5. Buat konfigurasi Midtrans Snap:

   * transaction_details
   * customer_details

6. Generate Snap Token menggunakan Midtrans SDK.

7. Simpan Snap Token ke kolom:

   * snap_token

8. Kembalikan halaman checkout yang memuat:

   * Snap JS Midtrans
   * Client Key Midtrans

9. Ketika tombol "Bayar Sekarang" ditekan:

   * Jalankan snap.pay()
   * Tampilkan popup pembayaran Midtrans.

10. Gunakan sandbox Midtrans.

11. Jangan implementasikan callback/webhook dulu.

12. Jangan mengubah status produk menjadi Sold dulu.

13. Fokus hanya sampai popup pembayaran Midtrans berhasil muncul.

Gunakan best practice Laravel:

* Service Class untuk Midtrans.
* Dependency Injection.
* Config terpisah.
* Error handling jika Midtrans gagal menghasilkan token.

Output yang saya inginkan:

* Config Midtrans lengkap.
* Service Midtrans lengkap.
* CheckoutController lengkap.
* Route lengkap.
* Blade checkout lengkap.
* Contoh file .env.
* Struktur folder yang direkomendasikan.

Target akhir:
Produk → Checkout → Generate Transaction → Generate Snap Token → Popup Midtrans Muncul.
