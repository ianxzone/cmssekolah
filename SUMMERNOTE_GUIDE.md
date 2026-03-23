# 📝 Summernote Rich Text Editor - User Guide

## 🎯 Overview

CMS Anda sekarang menggunakan **Summernote v0.9.0** sebagai WYSIWYG (What You See Is What You Get) editor untuk membuat dan mengedit konten post.

---

## ✨ Fitur Utama

### 1. **Text Formatting**
- **Bold** (Ctrl+B) - Teks tebal
- *Italic* (Ctrl+I) - Teks miring
- <u>Underline</u> (Ctrl+U) - Teks bergaris bawah
- ~~Strikethrough~~ - Teks dicoret
- Superscript & Subscript - Untuk notasi matematika/kimia

### 2. **Heading & Paragraph Styles**
- Heading 1, Heading 2, Heading 3
- Paragraph
- Blockquote
- Preformatted (Code blocks)

### 3. **Lists**
- Bullet List (Unordered list)
- Numbered List (Ordered list)
- Indent & Outdent

### 4. **Media Insertion**
- 🖼️ **Images**: Upload gambar dari komputer atau drag & drop
- 🔗 **Links**: Insert hyperlink
- 🎬 **Videos**: Embed video dari YouTube atau URL lain
- 📊 **Tables**: Insert tabel dengan kolom dan baris

### 5. **Advanced Features**
- 🎨 **Text Color**: Pilih warna teks dari palette
- 📏 **Line Height**: Atur jarak antar baris
- 🔍 **Code View**: Edit HTML langsung
- ⛶ **Fullscreen**: Mode layar penuh untuk fokus menulis
- ❌ **Clear Format**: Hapus semua formatting

---

## 🚀 Cara Menggunakan

### Upload Gambar

#### Metode 1: Drag & Drop
1. Buka folder gambar di komputer Anda
2. Drag file gambar ke area editor
3. Gambar akan otomatis di-upload dan inserted

#### Metode 2: Insert Image Button
1. Klik icon **Picture** (🖼️) di toolbar
2. Pilih file gambar dari komputer
3. Klik Open untuk upload
4. Gambar akan muncul di editor

#### Metode 3: Copy-Paste
1. Copy gambar dari aplikasi lain
2. Paste (Ctrl+V) langsung ke editor
3. Gambar akan otomatis tersimpan

### Insert Tabel

1. Klik icon **Table** (⊞)
2. Pilih jumlah kolom dan baris yang diinginkan
3. Tabel akan inserted ke editor
4. Klik di dalam sel untuk edit konten

### Mengatur Warna Teks

1. Seleksi teks yang ingin diwarnai
2. Klik icon **Color** (A▼)
3. Pilih warna dari palette
4. Teks akan berubah sesuai warna yang dipilih

### Fullscreen Mode

1. Klik icon **Fullscreen** (⛶)
2. Editor akan memenuhi layar
3. Klik lagi untuk keluar dari fullscreen mode

### Code View (HTML Editing)

1. Klik icon **Code View** (`</>`)
2. Editor akan menampilkan kode HTML
3. Edit HTML sesuai kebutuhan
4. Klik lagi untuk kembali ke visual editor

---

## 💡 Tips & Tricks

### Keyboard Shortcuts
| Shortcut | Action |
|----------|--------|
| `Ctrl+B` | Bold |
| `Ctrl+I` | Italic |
| `Ctrl+U` | Underline |
| `Ctrl+Z` | Undo |
| `Ctrl+Y` | Redo |
| `Ctrl+K` | Insert Link |
| `Ctrl+Shift+V` | Paste without formatting |

### Best Practices

1. **Save Frequently**: Selalu simpan draft secara berkala
2. **Use Headings**: Gunakan heading hierarchy (H1 > H2 > H3) untuk struktur konten
3. **Optimize Images**: Compress gambar sebelum upload untuk performa lebih baik
4. **Preview First**: Gunakan preview sebelum publish untuk memastikan tampilan
5. **Alt Text**: Tambahkan alt text pada gambar untuk accessibility

### Image Optimization

Sebelum upload gambar:
- Resize ke ukuran maksimal 1920px width
- Compress ke format WebP atau JPG quality 80%
- File size ideal: < 500KB
- Gunakan nama file descriptive (e.g., `students-learning.jpg`)

---

## 🎨 Toolbar Layout

```
┌─────────────────────────────────────────────────────┐
│ [Style ▼] [B][I][U][Clear]                          │
│ [Font ▼] [S][Sup][Sub]                              │
│ [Size ▼] [Color ▼]                                  │
│ [Para ▼] [•][1][¶][↕]                               │
│ [Table ▼]                                           │
│ [Link][Picture][Video][HR]                          │
│ [Fullscreen][Code View][Help]                       │
└─────────────────────────────────────────────────────┘
```

### Toolbar Sections:

1. **Style Group**: Basic text formatting
2. **Font Group**: Font effects (strikethrough, superscript, subscript)
3. **Size & Color**: Font size and text color
4. **Paragraph**: Lists, alignment, line height
5. **Insert**: Tables, links, images, videos, horizontal rules
6. **View**: Fullscreen, code view, help

---

## 🔧 Troubleshooting

### Masalah: Gambar tidak muncul setelah upload
**Solusi:**
- Pastikan file size < 5MB
- Cek koneksi internet
- Refresh halaman dan coba lagi

### Masalah: Toolbar tidak responsif
**Solusi:**
- Clear browser cache (Ctrl+Shift+Delete)
- Hard refresh (Ctrl+F5)
- Coba browser lain

### Masalah: Format hilang saat paste
**Solusi:**
- Gunakan Ctrl+Shift+V untuk paste plain text
- Atau paste normal untuk menjaga formatting

### Masalah: Editor terlihat rusak
**Solusi:**
- Logout dan login kembali
- Clear browser cache
- Pastikan JavaScript enabled di browser

---

## 📱 Mobile Usage

Summernote juga responsive untuk mobile devices:

### Touch Gestures
- **Tap**: Select text or place cursor
- **Double Tap**: Select word
- **Triple Tap**: Select paragraph
- **Pinch**: Zoom in/out (browser dependent)

### Mobile Tips
- Gunakan landscape mode untuk screen lebih luas
- Toolbar akan adjust untuk layar kecil
- Beberapa fitur advanced mungkin terbatas di mobile

---

## 🔒 Security Notes

### Image Upload Security
- Hanya file image yang diperbolehkan (JPG, PNG, GIF, WebP)
- File size maksimal: 5MB
- File akan divalidasi sebelum disimpan
- Malicious files akan ditolak otomatis

### Content Security
- XSS protection aktif
- Dangerous HTML tags akan difilter
- Scripts dan iframes diblokir
- Always preview before publishing

---

## 📊 Word Count Feature

Editor dilengkapi dengan real-time word counter:

- **Location**: Top-right corner of content field
- **Updates**: Real-time saat mengetik
- **Counts**: Total words (bukan characters)
- **Use Case**: Untuk memenuhi requirement minimal kata

---

## 🎓 Advanced Usage Examples

### Membuat Tutorial dengan Code Blocks

```html
<pre><code>
function helloWorld() {
    console.log("Hello, World!");
}
</code></pre>
```

### Insert YouTube Video

1. Klik icon **Video**
2. Paste YouTube URL (e.g., `https://www.youtube.com/watch?v=dQw4w9WgXcQ`)
3. Click **Insert Video**

### Membuat Table Data

| Column 1 | Column 2 | Column 3 |
|----------|----------|----------|
| Data A   | Data B   | Data C   |

1. Insert table 3x3
2. Fill cells dengan data
3. Format header row dengan bold

---

## 🆘 Need Help?

Jika mengalami masalah:

1. **Check Documentation**: Baca guide ini terlebih dahulu
2. **Clear Cache**: Browser cache bisa menyebabkan masalah
3. **Try Different Browser**: Test di browser lain
4. **Contact Admin**: Laporkan bug atau feature request

---

## 🔄 Updates & Maintenance

Editor ini akan di-update secara berkala untuk:
- Security patches
- Bug fixes
- New features
- Performance improvements

---

**Happy Writing! ✍️**

*Last Updated: March 16, 2026*
