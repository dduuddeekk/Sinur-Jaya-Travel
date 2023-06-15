<!-- Rute ini cuma buat nampilin google maps aja awok awok, jangan dibawa serius, sorry bang -->

<?php
    include "../php/connect.php";
    $collection = $database->selectCollection("tiket");
    $documents = $collection->find();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="../style/rute.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>RUTE</title>
    <style>
        h2{
            text-align: center;
            color: #fcd733;
            margin-top: 10px;
            margin-bottom: 10px;
            font-family: "Roboto", sans-serif;
        }
    </style>
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

                    <li><a id ="userRoute" href="../php/rute.php">rute</a></li>
                    <script src="../javascript/routers.js"></script>

                    <li><a id="userTikets" href="../php/tiket.php">tiket</a></li>
                    <script src="../javascript/tiketers.js"></script>
                </ul>
            </nav>
        </div>
        <div class="rutenya">
            <h2>RUTE BUS SINUR JAYA</h2>
            <ul class="rutelist">
                <?php foreach ($documents as $document): ?>
                    <li>
                        <span>Tujuan: <?php echo $document["destination"]; ?></span><br>
                        <span>Tanggal Keberangkatan: <?php echo $document["date"]; ?></span><br>
                        <?php
                            $tujuan = $document["destination"];
                            $mapsUrl = "https://maps.google.com/maps?q=" . urlencode($tujuan) . "&t=&z=13&ie=UTF8&iwloc=&output=embed";
                        ?>
                        <iframe src="<?php echo $mapsUrl; ?>" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <script src="../javascript/button.js"></script>
</body>
</html>