<?php
    include "../php/connect.php";

    $userCollection = $database->selectCollection("users");

    $userDocument = null;

    if (isset($_GET["username"])) {
        $username = $_GET["username"];

        $query = [
            "username" => $username
        ];

        $userDocument = $userCollection->findOne($query);
    }

    $userid = $userDocument["id"];

    $collection = $database->selectCollection("tiket");
    $documents = $collection->find(["userid" => $userid]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="../style/tiket.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Tiket User</title>
</head>
<body>
    <div class="container">
        <div class="headings">
            <div class="brand">
                <span class="brand-text">sinur jaya travel</span>
                <span class="menu" onclick="openBtn()"><i class="fas fa-bars"></i></span>
            </div>
        </div>
        <div class="rightmenu" id="rightMenu">
            <a href="#" class="button" onclick="closeBtn()">x</a>
            <nav class="navigations">
                <ul>
                    <li><a id="userMain" href="../php/userindex.php">beranda</a></li>
                    <li><a id="userLink" href="../php/user.php">akun</a></li>
                    <li><a id="userBus" href="../php/bus.php">bus</a></li>
                    
                    <script src="../javascript/mainer.js"></script>
                    <script src="../javascript/linker.js"></script>
                    <script src="../javascript/buser.js"></script>

                    <li><a href="#">rute</a></li>

                    <li><a id="userTikets" href="../php/tiket.php">tiket</a></li>
                    <script src="../javascript/tiketers.js"></script>
                </ul>
            </nav>
        </div>
        <div class="tiketnya">
            <ul class="tiketlist">
                <?php foreach ($documents as $document): ?>
                    <li>
                        <img class="tiket-image" src="../image/tiket.png" alt="tiket bang"/>
                        <span>ID: <?php echo $document["id"]; ?></span><br>
                        <span>ID Bus: <?php echo $document["busid"]; ?></span><br>
                        <span>Tujuan: <?php echo $document["destination"]; ?></span><br>
                        <span>Tanggal Keberangkatan: <?php echo $document["date"]; ?></span><br>
                        <span>Total Harga: <?php echo $document["price"]; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <script src="../javascript/button.js"></script>
</body>
</html>
