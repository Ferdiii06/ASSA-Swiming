# 🏊‍♂️ Manual Book: Sistem Informasi Jadwal & Raport Les Renang (ASSA-Swimming)

Selamat datang di Panduan Penggunaan (Manual Book) Sistem Informasi Jadwal & Raport Les Renang. Dokumen ini disusun untuk membantu Anda memahami dan menggunakan seluruh fitur yang ada di dalam aplikasi web ini.

---

## 📑 Daftar Isi
1. [Bab 1: Pendahuluan](#bab-1-pendahuluan)
2. [Bab 2: Panduan Akses & Autentikasi](#bab-2-panduan-akses--autentikasi)
3. [Bab 3: Panduan Pengguna - ADMIN](#bab-3-panduan-pengguna---admin)
4. [Bab 4: Panduan Pengguna - PELATIH (COACH)](#bab-4-panduan-pengguna---pelatih-coach)
5. [Bab 5: Panduan Pengguna - ORANG TUA & MURID](#bab-5-panduan-pengguna---orang-tua--murid)
6. [Bab 6: Sistem Pembayaran (Payment Gateway)](#bab-6-sistem-pembayaran)

---

## Bab 1: Pendahuluan
Aplikasi ini adalah sistem manajemen komprehensif yang dirancang untuk memudahkan operasional tempat les renang. Sistem ini menghubungkan tiga pihak utama: **Admin**, **Pelatih (Coach)**, dan **Orang Tua/Murid**. 

**Fitur Utama Sistem:**
- Pendaftaran akun terintegrasi Google (SSO).
- Manajemen data pelatih, murid, dan orang tua.
- Pemilihan paket latihan dan jadwal.
- Pembayaran otomatis menggunakan Midtrans.
- Pengisian dan pencetakan Raport Evaluasi Siswa secara digital.

---

## Bab 2: Panduan Akses & Autentikasi

Semua pengguna harus memiliki akun untuk mengakses fitur dalam sistem.

### 2.1 Cara Mendaftar Akun Baru
1. Buka halaman utama website.
2. Klik tombol **Register** atau **Daftar**.
3. Isi formulir pendaftaran dengan nama, email, dan password yang valid.
4. Klik **Daftar**.
5. *Alternatif (Lebih Cepat):* Anda bisa mengklik tombol **"Login with Google"** untuk langsung mendaftar dan masuk tanpa perlu mengingat password.

### 2.2 Cara Verifikasi Email
1. Setelah mendaftar menggunakan email standar, periksa kotak masuk email Anda.
2. Cari email masuk dari sistem ASSA-Swimming.
3. Klik tombol **"Verifikasi Email"**. Anda akan diarahkan kembali ke Dashboard.

### 2.3 Cara Melengkapi Profil
1. Setelah login pertama kali, sistem akan mengarahkan Anda ke halaman Profil.
2. Lengkapi data diri Anda secara detail.
3. Klik **Simpan** / **Complete Profile**.

---

## Bab 3: Panduan Pengguna - ADMIN

Admin adalah pemegang kendali utama di dalam sistem.

### 3.1 Mengelola Data Master (Programs & Packages)
1. Masuk ke menu **Manajemen Program**.
2. Klik **Tambah Program Baru** untuk membuat kategori latihan baru (misal: *Kelas Pemula, Kelas Prestasi*).
3. Masuk ke menu **Manajemen Paket** untuk membuat pilihan harga berdasarkan program yang ada (misal: *Paket 4x Pertemuan, Paket 8x Pertemuan*).

### 3.2 Mengelola Pengguna (Pelatih & Orang Tua)
- **Menambah Pelatih:** Masuk ke menu Data Pelatih -> Klik Tambah Data. Isikan profil pelatih.
- **Edit/Hapus Data:** Pada tabel data Pelatih/Orang Tua, terdapat tombol *Edit* (✏️) dan *Delete* (🗑️) di masing-masing baris.
- **Hapus Banyak Data (Bulk Destroy):** Centang beberapa nama sekaligus, lalu klik tombol **Hapus Data Terpilih**.

### 3.3 Verifikasi Pembayaran Manual
Jika ada murid yang melakukan pembayaran via transfer bank langsung (di luar Midtrans):
1. Buka menu **Daftar Pembayaran (Admin)**.
2. Cari nama murid dengan status pembayaran `Pending`.
3. Periksa bukti transfer yang diunggah.
4. Klik tombol **Approve** untuk mengkonfirmasi bahwa dana telah masuk. Murid akan otomatis terdaftar ke kelas.

---

## Bab 4: Panduan Pengguna - PELATIH (COACH)

Pelatih bertugas untuk mengawasi jadwal dan memberikan penilaian kepada murid.

### 4.1 Melihat Jadwal Latihan
1. Login menggunakan akun Pelatih.
2. Buka menu **Jadwal Saya**.
3. Di sini akan tampil daftar hari, jam, dan murid-murid yang akan diajar.

### 4.2 Mengisi Raport Evaluasi (Penilaian Murid)
1. Buka menu **Data Siswa** atau klik nama murid pada jadwal Anda.
2. Klik tombol **Isi Evaluasi / Penilaian**.
3. Masukkan nilai untuk setiap parameter keterampilan renang (misal: *Kecepatan, Teknik Gaya Bebas, Pernapasan*).
4. Berikan **Catatan Pelatih** sebagai pesan penyemangat atau evaluasi untuk orang tua.
5. Klik **Simpan Evaluasi**. Data ini otomatis akan membentuk Raport Digital.

---

## Bab 5: Panduan Pengguna - ORANG TUA & MURID

### 5.1 Memilih dan Mendaftar Kelas
1. Login ke Dashboard Orang Tua/Murid.
2. Buka menu **Program Les** atau **Daftar Kelas**.
3. Pilih program yang sesuai dengan tingkatan murid.
4. Pilih **Paket Latihan** (misal: *Paket 1 Bulan*).
5. Konfirmasi pendaftaran. Anda akan diarahkan ke halaman pembayaran.

### 5.2 Melihat Raport Les Renang
1. Pada menu utama, klik **Raport Siswa** atau **Progress Report**.
2. Anda akan melihat grafik atau tabel perkembangan nilai dari pelatih setiap bulannya.
3. Anda dapat mengunduh Raport dalam bentuk **PDF** dengan mengklik tombol **Cetak Raport / Download PDF**.

---

## Bab 6: Sistem Pembayaran (Payment Gateway)

Sistem ini terintegrasi dengan **Midtrans**, sehingga pembayaran aman dan otomatis terverifikasi.

### 6.1 Langkah-Langkah Pembayaran Otomatis
1. Setelah memilih paket latihan, klik tombol **Bayar Sekarang**.
2. Sebuah jendela (pop-up) Midtrans akan muncul.
3. Pilih metode pembayaran yang Anda inginkan:
   - **Virtual Account (VA):** BCA, Mandiri, BNI, BRI.
   - **E-Wallet:** GoPay, ShopeePay, OVO, Dana.
   - **QRIS:** Pindai barcode menggunakan aplikasi M-Banking atau E-Wallet apa saja.
4. Selesaikan pembayaran sesuai instruksi di layar sebelum batas waktu habis (biasanya 24 jam).
5. Setelah sukses dibayar, status pembayaran di Dashboard akan otomatis berubah menjadi **Lunas (Paid)**, dan murid resmi terdaftar di jadwal latihan.

---
*Manual book ini ditulis pada September 2026 dan disesuaikan dengan versi rilis terkini dari aplikasi ASSA-Swimming.*
