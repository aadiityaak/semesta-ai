# Semesta AI - Plugin Tools UMKM

Semesta AI adalah plugin WordPress yang menyediakan berbagai alat bantu digital untuk UMKM, seperti Kalkulator HPP, Caption Generator (berbasis Google Gemini AI), dan Manajemen Template Konten.

## Fitur Utama

### 1. Caption Generator (AI Powered)
Membuat caption media sosial (Instagram, TikTok, WhatsApp, dll) secara otomatis menggunakan teknologi Google Gemini AI.
- **Input:** Nama Produk, Jenis Usaha, Target Market, Platform, dan Tone of Voice.
- **Fitur:** 
  - Generate caption otomatis.
  - Copy to clipboard (dengan fallback support).
  - Modal notification untuk error handling.
- **Shortcode:** `[semesta_caption]`

### 2. Kalkulator HPP (Harga Pokok Penjualan)
Menghitung HPP produk secara detail mulai dari bahan baku, tenaga kerja, hingga biaya operasional.
- **Fitur:**
  - Perhitungan otomatis real-time.
  - Masking ribuan (format Rupiah) pada input angka.
  - Export hasil perhitungan ke PDF dan PNG dengan layout profesional.
  - Footer branding pada hasil export.
- **Shortcode:** `[semesta_hpp_calculator]`

### 3. Template Konten & Kalender
Menyediakan berbagai template dokumen siap pakai untuk kebutuhan konten kreator dan bisnis.
- **Fitur:**
  - Custom Post Type "Template Konten" untuk manajemen template.
  - Support upload file (Excel, PDF, Doc) atau link Google Sheet.
  - Tampilan frontend dinamis dengan ikon sesuai tipe file.
- **Shortcode:** `[semesta_template_content]`

## Instalasi

1. Upload folder `semesta-ai` ke direktori `/wp-content/plugins/`.
2. Aktifkan plugin melalui menu **Plugins** di WordPress Dashboard.
3. Masuk ke menu **Semesta AI > Settings** untuk memasukkan Google API Key.

## Konfigurasi

### Google API Key
Untuk menggunakan fitur Caption Generator, Anda memerlukan API Key dari Google AI Studio.
1. Dapatkan API Key di [Google AI Studio](https://makersuite.google.com/app/apikey).
2. Masukkan key di menu **Semesta AI > Settings**.
3. Model yang digunakan saat ini adalah `gemini-3-flash-preview`.

### Template Konten
Untuk menambahkan template baru:
1. Masuk ke menu **Template Konten > Tambah Baru**.
2. Isi Judul dan Deskripsi template.
3. Upload file template atau masukkan link Google Sheet pada metabox yang tersedia.
4. Pilih jenis template dan sesuaikan teks tombol download.

## Struktur File Penting

- `semesta-ai.php` - File utama plugin.
- `src/Api/GoogleAiController.php` - Controller untuk komunikasi dengan Google Gemini API.
- `src/Core/PostTypes.php` - Registrasi CPT dan Metabox Template.
- `templates/frontend/` - File view untuk frontend (Alpine.js & Tailwind CSS).
  - `caption-generator.php`
  - `hpp-calculator.php`
  - `template-content.php`

## Teknologi
- **Backend:** PHP, WordPress REST API.
- **Frontend:** Alpine.js, Tailwind CSS (CDN).
- **Library Tambahan:** html2canvas, jsPDF (untuk fitur export).

---
*Dibuat dengan ❤️ untuk UMKM Indonesia.*
