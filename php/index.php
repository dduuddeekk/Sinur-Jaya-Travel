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
    <style>
        .busnya{
            background-color: aliceblue; 
        }

        .buslist {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-items: flex-start;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .buslist li {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px;
            padding: 10px;
            background-color: #fcd733;
            color: aliceblue;
        }

        .buslist li .gambarbusanjay {
            width: 200px;
            height: 150px;
            margin-bottom: 10px;
        }
    </style>
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
            <p>Platform pembelian tiket bus terpercaya, ya, Sinur Jaya Travel. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non consequuntur omnis harum laborum facilis deserunt molestias voluptate nostrum, tempore eius fuga! Blanditiis recusandae asperiores quam itaque, maiores ullam officiis vero.</p>
        </div>
        <div class="rightmenu" id="rightMenu">
            <a href="#" class="button" onclick="closeBtn()">x</a>
            <nav class="navigations">
                <ul>
                    <li><a href="../php/index.php">Beranda</a></li>
                    <li><a href="../html/login.html">Akun</a></li>
                    <li><a href="../html/login.html">Bus</a></li>
                    <li><a href="../html/login.html">Rute</a></li>
                    <li><a href="../html/login.html">Tiket</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="busnya">
        <ul class="buslist">
            <?php foreach ($documents as $document): ?>
                <li>
                    <img src="<?php echo $document["image"]; ?>" class="gambarbusanjay" alt="...">
                    <span>ID: <?php echo $document["id"]; ?></span><br>
                    <span>Plat: <?php echo $document["plat"]; ?></span><br>
                    <span>Jenis: <?php echo $document["type"]; ?></span><br>
                    <span>Kursi: <?php echo $document["chair"]; ?></span><br>
                    <form action="../html/login.html">
                        <button type="submit">Beli</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="../javascript/button.js"></script>
</body>
</html>
