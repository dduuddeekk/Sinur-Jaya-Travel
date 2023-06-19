<?php
include "../php/connect.php";

$id = isset($_GET["id"]) ? $_GET["id"] : "";

$userDocument = null;
$userid = "";

if (!empty($id)) {
    $userCollection = $database->selectCollection("users");
    $userDocument = $userCollection->findOne(["id" => $id]);
    $userid = $userDocument ? $userDocument["id"] : "";
}

$collection = $database->selectCollection("bus");
$documents = $collection->find();

$searchKeyword = isset($_GET["search"]) ? $_GET["search"] : "";
$filteredDocuments = [];

if (!empty($searchKeyword)) {
    $filter = ['$or' => [
        ["id" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["plat" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["type" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["chair" => ['$regex' => $searchKeyword, '$options' => 'i']]
    ]];

    $filteredDocuments = $collection->find($filter);
} else {
    $filteredDocuments = $documents;
}
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
    <title>BUS</title>
    <style>

        .busnya {
            background-color: aliceblue; 
            width: 100%;
            max-width: auto;
            padding: 20px;
            box-sizing: border-box;
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

        .buslist li .busimage {
            width: 200px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .searchbar {
            margin-bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .searchbar form {
            display: flex;
            align-items: center;
        }

        .searchbar input[type="text"] {
            padding: 5px;
            width: 200px;
            border: 1px solid #fcd733;
            border-radius: 4px;
            margin-right: 5px;
        }

        .searchbar button {
            padding: 7px 10px;
            background-color: #fcd733;
            color: aliceblue;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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
        <div class="rightmenu" id="rightMenu">
            <a href="#" class="button" onclick="closeBtn()">x</a>
            <nav class="navigations">
                <ul>
                    <li><a id="userMain" href="../php/userindex.php">beranda</a></li>
                    <li><a id="userLink" href="../php/user.php">akun</a></li>
                    <li><a id="userBus" href="../php/bus.php">bus</a></li>
                    <li><a id="userRoute" href="../php/rute.php">rute</a></li>
                    <li><a id="userTikets" href="../php/tiket.php">tiket</a></li>
                    <script src="../javascript/mainer.js"></script>
                    <script src="../javascript/linker.js"></script>
                    <script src="../javascript/buser.js"></script>
                    <script src="../javascript/router.js"></script>
                    <script src="../javascript/tiketers.js"></script>
                </ul>
            </nav>
        </div>
        <div class="busnya">
            <div class="searchbar">
                <form action="../php/bus.php" method="GET">
                    <input type="text" name="search" placeholder="Cari bus ...." value="<?php echo $searchKeyword; ?>">
                    <button type="submit" class="fas fa-search"></button>
                </form>
            </div>
            <ul class="buslist">
                <?php foreach ($filteredDocuments as $document): ?>
                    <li>
                        <img class="busimage" src="<?php echo $document['image']; ?>" alt="Bus Image">
                        <span>ID: <?php echo $document["id"]; ?></span><br>
                        <?php $busid = $document["id"]; ?>
                        <span>Plat: <?php echo $document["plat"]; ?></span><br>
                        <span>Jenis: <?php echo $document["type"]; ?></span><br>
                        <span>Kursi: <?php echo $document["chair"]; ?></span><br>
                        <?php if (!empty($userid)): ?>
                            <form action="../php/formtiket.php?busid=<?php echo $busid; ?>&userid=<?php echo $userid; ?>" method="POST">
                                <button type="submit">Beli</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <script src="../javascript/button.js"></script>
    </div>
</body>
</html>