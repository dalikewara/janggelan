# Janggelan

"Hanya sebuah <i>framework</i> PHP yang tidak terduga." ~Dali Kewara

## Dukungan Bahasa

Dokumentasi, komentar, dan penjelasan pada program Janggelan untuk saat ini hanya tersedia
untuk Bahasa Indonesia. Dukungan bahasa ditandai dengan indikasi folder. Bahasa Inggris dan
lain-lain akan segera menyusul.

## Fitur (0.0.1 Z Rev 3)

- Proses MVC dilakukan di dalam satu folder bernama "mvc", sehingga membuat pekerjaan menjadi
  lebih mudah. Folder "mvc" terdiri dari folder "models, views, dan controllers".

- Pendaftaran url/rute-rute berada di file requests.php di dalam folder mvc.

- Konfigurasi "auto_connect" untuk Database. Anda bebas memutuskan apakah Janggelan boleh
  melakukan koneksi ke Database secara otomatis atau tidak. Jika tidak, maka Anda bisa membuka
  koneksi secara manual dengan sintax: $model->Open();. Untuk mematikan gunakan: $model->Die();

- Fungsi untuk membuat tabel ke Database. Syntax: $model->Create();.

- Tugas-tugas untuk Model. "Select()", "Clause()", dan "BindParam()".

- Kirim data dari Controller ke View dengan fungsi "compact()".

- Konfigurasi "debug dan error reporting".

- dan fitur-fitur lain.

## Kebutuhan Sistem
- PHP > 5.4.
- Extensi PHP PDO.

## Author

Dali Kewara <dalikewara@windowslive.com>

## Lisensi

Janggelan merupakan program atau software yang bersifat "Open Source".
