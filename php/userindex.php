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
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>BERANDA</title>
</head>
<body>
    <div class="container">
        <div class="headings">
            <div class="brand">
                <span class="brand-text">sinur jaya travel</span>
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
                    <li><a id="userMain" href="../php/userindex.php">beranda</a></li>
                    <li><a id="userLink" href="../php/user.php">akun</a></li>
                    
                    <script src="../javascript/mainer.js"></script>
                    <script src="../javascript/linker.js"></script>

                    <li><a href="../php/seebus.php">bus</a></li>
                    <li><a href="rute.html">rute</a></li>
                    <li><a href="#">tiket</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="busnya">
        <ul class="buslist">
            <?php foreach ($documents as $document): ?>
                <li>
                    <span>ID: <?php echo $document["id"]; ?></span><br>
                    <span>Plat: <?php echo $document["plat"]; ?></span><br>
                    <span>Jenis: <?php echo $document["type"]; ?></span><br>
                    <span>Kursi: <?php echo $document["chair"]; ?></span><br>
                    <form action="../php/belitiket.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $document['id']; ?>">
                        <button type="submit">Beli</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="../javascript/button.js"></script>
</body>
</html>