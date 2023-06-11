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

Dalam MongoDB, membuat koleksi dapat dilakukan dengan menggunakan sintaks:

```mongosh
db.createCollection("namaKoleksi")
```

Akan tetapi, karena di sini menggunakan PHP, jadi akan ada beberapa improvisasi yang dilakukan seperti membuat beberapa variable, salah satunya dengan menghubungkannya ke satu berkas PHP dengan ```include```. Jadi, kami bisa mempermudahnya menjadi:

```php
$collection = $database->createCollection("namaKoleksi");
```

Berikut adalah salah satu sintaks yang digunakan dalam Sinur Jaya Travel:

```php
$collectionName = "users";
$collectionNames = $database->listCollectionNames();
$collectionExist = in_array($collectionName, iterator_to_array($collectionNames));
$collection = null;

if ($collectionExist) {
    $collection = $database->selectCollection($collectionName);
} else {
    $collection = $database->createCollection($collectionName);
}
```

Sintaks di atas terdapat di dalam berkas bernama register.php. Sederhananya, algoritma dari program ini adalah ketika koleksi tidak ada maka dia akan membuat koleksi tersebut dan ketika koleksi ada maka koleksi akan di-*select*.

## INSERT

Ada beberapa kode atau sintaks *insert* dalam Sinur Jaya Travel, dan masing-masing memiliki algoritma yang berbeda, tapi yang menjadi favorit saya adalah yang terdapat di dalam buytiket.php.

```php
<?php
    include "../php/connect.php";

    $collectionName = "tiket";
    $collectionNames = $database->listCollectionNames();
    $collectionExist = in_array($collectionName, iterator_to_array($collectionNames));
    $collection = null;

    if ($collectionExist) {
        $collection = $database->selectCollection($collectionName);
    } else {
        $collection = $database->createCollection($collectionName);
    }

    $busid = $_POST["busid"];
    $userid = $_POST["userid"];
    $destination = $_POST["destination"];
    $date = $_POST["date"];

    $sumatra = array(
        "Aceh",
        "Sumatera Utara",
        "Sumatera Barat",
        "Riau",
        "Kepulauan Riau",
        "Jambi",
        "Sumatera Selatan",
        "Bangka Belitung",
        "Bengkulu",
        "Lampung"
    );
    $jawa = array(
        "DKI Jakarta",
        "Jawa Barat",
        "Jawa Tengah",
        "DI Yogyakarta",
        "Jawa Timur",
        "Banten"
    );
    $nusaTenggara = array(
        "Nusa Tenggara Barat",
        "Nusa Tenggara Timur"
    );
    $kalimantan = array(
        "Kalimantan Barat",
        "Kalimantan Tengah",
        "Kalimantan Selatan",
        "Kalimantan Timur",
        "Kalimantan Utara"
    );
    $sulawesi = array(
        "Sulawesi Utara",
        "Gorontalo",
        "Sulawesi Tengah",
        "Sulawesi Barat",
        "Sulawesi Selatan",
        "Sulawesi Tenggara"
    );
    $maluku = array(
        "Maluku",
        "Maluku Utara"
    );
    $papua = array(
        "Papua",
        "Papua Barat"
    );

    $price = 0;

    $busCollection = $database->selectCollection("bus");

    $tempid = $busid;
    $busDocument = $busCollection->find(["id" => $tempid]);

    foreach ($busDocument as $bus){
        $type = $bus['type'];
        switch($type){
            case 'BIG':
                $price = 200000;
                break;
            case 'MEDIUM':
                $price = 100000;
                break;
            case 'MICRO':
                $price = 50000;
                break;
            default:
                $price = 0;
                break;
        }
    }

    if(in_array($destination, $jawa) || in_array($destination, $nusaTenggara)){
        $price *= 1.5;
    }else if(in_array($destination, $sumatra)){
        $price *= 2;
    }else if(in_array($destination, $kalimantan)){
        $price *= 3;
    }else if(in_array($destination, $sulawesi)){
        $price *= 3.5;
    }else if(in_array($destination, $maluku) || in_array($destination, $papua)){
        $price *= 4;
    }

    $id = generateTiketId();

    $query = [
        "id" => $id,
        "busid" => $busid,
        "userid" => $userid,
        "destination" => $destination,
        "date" => $date,
        "price" => $price
    ];

    $document = $collection->insertOne($query);

    if($document){
        header("Location: ../php/tiketsuccess.php?id=$userid");
        exit();
    }else{
        echo "Something went wrong.";
    }

    function generateTiketId() {
        $randomNumber = mt_rand(1, 99999999);
        $paddedNumber = str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
        return "TKT" . $paddedNumber;
    }
?>
```

Kenapa demikian? Karena program ini menggunakan lebih dari satu koleksi untuk hanya melakukan *insert*. Kode ini melibatkan koleksi bus, users, dan tiket sebagai tujuannya. Tentu saja ini membingungkan mengingat MongoDB tidak memiliki relasi seperti SQL, tapi masih bisa diambil dalam sebuah variabel seperti kita menggunakan C dan TXT.

## UPDATE

Dalam Sinur Jaya Travel, ada beberapa *update*, tapi tidak semua bisa saya berikan di dalam *markdown* ini. Kebanyakan *update* yang dilakukan melibatkan berkas berupa gambar. Salah satunya:

```php
<?php
    include "../php/connect.php";
    $collection = $database->selectCollection("users");
    $id = isset($_POST["id"]) ? $_POST["id"] : "";
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/updateuser.css" />
    <title>PERBARUI AKUN</title>
</head>
<body>
    <h1>PERBARUI AKUN</h1>
    <form action="updateuser.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="password" value="<?php echo $password; ?>">
        <label for="image">Foto:</label>
        <input type="file" name="image" />
        <label for="name">Nama:</label>
        <input type="text" name="name">
        <label for="address">Alamat:</label>
        <input type="text" name="address">
        <label for="number">Nomor Telepon:</label>
        <input type="text" name="number">
        <div class="button-container">
            <button type="submit">SIMPAN</button>
            <a href="javascript:history.back()" class="button-cancel">BATAL</a>
        </div>
    </form>
</body>
</html>
```

Ini merupakan program mengambil data users saat ingin melakukan *update*. Jadi algoritma yang saya gunakan adalah dari user.php lalu menuju ke getuser.php lalu data diproses di updateuser.php dan berakhir ke user.php lagi.

```php
<?php
    include "../php/connect.php";
    $collection = $database->users;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST["id"];
        $username = $_POST["username"];
        $gambar = $_FILES["image"];
        $nama = isset($_POST["name"]) ? $_POST["name"] : "";
        $alamat = isset($_POST["address"]) ? $_POST["address"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $nomor = isset($_POST["number"]) ? $_POST["number"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";

        $filter = [ "id" => $id ];
        $update = [
            '$set' => [
                "profile" => $gambar,
                "name" => $nama,
                "address" => $alamat,
                "email" => $email,
                "number" => $nomor,
                "username" => $username,
                "password" => $password 
            ]
        ];

        // Handle the uploaded file
        if ($gambar["error"] === UPLOAD_ERR_OK) {
            $tempFilePath = $gambar["tmp_name"];
            $extension = pathinfo($gambar["name"], PATHINFO_EXTENSION);
            $destinationPath = '../image/userprofile/' . $id . '.' . $extension;
            move_uploaded_file($tempFilePath, $destinationPath);
            $update['$set']['profile'] = $destinationPath;
        }        

        $result = $collection->updateOne($filter, $update);

        if ($result->getModifiedCount() > 0) {
            header("Location: ../php/user.php?username=$username");
            exit();
        } else {
            echo "id = " . $id . "<br>";
            echo "username = " . $username . "<br>";
            echo "gambar = " . $gambar . "<br>";
            echo "nama = " . $nama . "<br>";
            echo "alamat = " . $alamat . "<br>";
            echo "email = " . $email . "<br>";
            echo "nomor = " . $nomor . "<br>";
            echo "Update Failed";
        }
    }
?>
```

Karena beberapa kali sempat terjadi *error*, jadi saya memberikan banyak ```echo``` pada saat gagal melakukan *update* untuk mengetahui di mana variabel yang bernilai kosong.

## DELETE

Penghapusan data cukup sederhana.

```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idToDelete = $_POST["delete"];
    $collection->deleteOne(["id" => $idToDelete]);
    header("Location: ../php/listbus.php");
    exit();
}
```

## SPECIAL THANKS

Saya, I Kadek Indra Agusta Pratama, dari repository ini mengucapkan terima kasih yang sebesar-besarnya atas bantuan dan inspirasinya kepada:

1. Teman kelompok saya karena telah mau berdiskusi bersama saya, Dewa dan Pram.
2. Satya yang sudah menginspirasi saya menggunakan ```include```.
3. W3School karena memberikan beberapa sintaks.
4. ChatGPT karena melakukan *trace* program agar tidak error.
5. MongoDB, kalau bukan dia terus pakai apa?
6. Xampp karena menyediakan Apache server walau sering error.

## AKHIR KATA

![Semangat](/image/draco.webp)

***SEMANGAT***
