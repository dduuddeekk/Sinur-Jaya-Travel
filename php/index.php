<?php
    include "../php/connect.php";
    $collection = $database->selectCollection("bus");
    $documents = $collection->find();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <title>BERANDA</title>
</head>
<body>
    <div class="container">
        <div class="headings">
            <div class="brand">
                <span class="brand-text">Sinur Jaya Travel</span>
                <span class="menu" onclick="openBtn()"><i class="fas fa-bars"></i></span>
            </div>
        </div>
        <div class="welcome-text">
            <h1>Selamat Datang!</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum eius quas exercitationem esse quaerat, vel ea voluptas rem maxime error inventore voluptates eos pariatur cum provident saepe dolore totam unde.</p>
        </div>
        <div class="rightmenu" id="rightMenu">
            <a href="#" class="button" onclick="closeBtn()">x</a>
            <nav class="navigations">
                <ul>
                    <li><a href="../php/index.php">Beranda</a></li>
                    <li><a href="../html/login.html">Akun</a></li>
                    <li><a href="../php/seebus.php">Bus</a></li>
                    <li><a href="../php/rute.php">Rute</a></li>
                    <li><a href="../php/login.php">Tiket</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="busnya">
        <ul class="buslist">
            <?php foreach ($documents as $document): ?>
                <li>
                    <span>ID: <?php echo $document["id"]; ?></span>
                    <span>Plat: <?php echo $document["plat"]; ?></span>
                    <span>Jenis: <?php echo $document["jenis"]; ?></span>
                    <span>Kursi: <?php echo $document["kursi"]; ?></span>
                    <form action="../php/login.php">
                        <button type="submit">Beli</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="../javascript/button.js"></script>
</body>
</html>