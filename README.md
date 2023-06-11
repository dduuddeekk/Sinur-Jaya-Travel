# SINUR JAYA TRAVEL

Sinur Jaya Travel merupakan sebuah situs internet percobaan yang dilakukan oleh:

1. I Dewa Gd Dharma Pawitra (2205551041)
2. I Kadek Indra Agusta Pratama (2205551056)
3. GN Pramana Jagadhita (2205551077)

Dari Universitas Udayana, Progam Studi Teknologi Informasi.

Situs internet ini menggunakan PHP sebagai bahasa utamanya dan menggunakan MongoDB sebagai basis datanya.

## MongoDB ke PHP

Dalam penggunaan bahasa PHP tidak akan semudah ketika menggunakan Javascript dalam mengoneksikannya dengan basis data MongoDB. Kita memerlukan ekstensi tambahan yang berekstensi ".dll". Kita juga memerlukan yang namanya *composser* agar kita dapat mengambil *vendor* MongoDB. Setelah itu, baru kita bisa masukkan *client* MongoDB ke kode PHP.

```php
<?php
    require "../vendor/autoload.php" //directory opsional tergantung di mana kamu menaruhnya
    use MongoDB\Client; //kamu bisa sertakan host di sini
    $client = new MongoDB\Client;
    $database = $client->namaDatabase;
?>
```

Dalam MongoDB kita tidak perlu membuat basis data dengan cara *create* atau semacamnya. Ketika kita panggil saja basis datanya, dia akan otomatis terbuat atau tergunakan. Dan kode program di atas dapat digunakan di banyak berkas PHP dengan cara.

```php
<?php
    include "koneksi.php" //sesuaikan directorymu
    // ... lanjutan kode program.
?>
```

## CREATE

## INSERT

## UPDATE

## DELETE
