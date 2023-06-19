<?php
include "../php/connect.php";

$userCollection = $database->selectCollection("users");

$userDocument = null;

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query = [
        "id" => $id
    ];

    $userDocument = $userCollection->findOne($query);
}

$userid = null;

if ($userDocument !== null) {
    $userid = $userDocument["id"];
}

$collection = $database->selectCollection("tiket");

$searchQuery = [];
$search = null;

if (isset($_GET["search"])) {
    $search = $_GET["search"];

    $searchQuery = [
        '$or' => [
            ["id" => ['$regex' => $search, '$options' => 'i']],
            ["busid" => ['$regex' => $search, '$options' => 'i']],
            ["supirname" => ['$regex' => $search, '$options' => 'i']],
            ["destination" => ['$regex' => $search, '$options' => 'i']],
            ["date" => ['$regex' => $search, '$options' => 'i']],
            ["price" => ['$regex' => $search, '$options' => 'i']]
        ]
    ];
}

$destination = isset($_GET["destination"]) ? $_GET["destination"] : "";

if ($destination) {
    $documents = $collection->find(["destination" => $destination]);
} elseif ($userid) {
    $documents = $collection->find(array_merge(["userid" => $userid], $searchQuery));
} else {
    $documents = [];
}
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
    <style>
        .search-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .search-bar input[type="text"] {
            border: 2px solid #fcd733;
            border-radius: 5px;
            padding: 8px 10px;
            width: 300px;
            font-family: 'Roboto', sans-serif;
        }

        .search-bar button {
            background-color: #fcd733;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            margin-left: 10px;
            font-family: 'Roboto', sans-serif;
            color: #fff;
            cursor: pointer;
        }

        .filters{
            font-family: "Roboto", sans-serif;
            font-size: 20px;
            text-align: center;
        }

        .filters select{
            border: 1px solid #fcd733;
            padding: 7px 10px;
            font-size: 20px;
        }

        .filters button{
            background-color: #fcd733;
            border: 1px solid #fcd733;
            color: aliceblue;
            font-size: 20px;
            padding: 7px 10px;
            border-radius: 5px;
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
                    <li><a id="userRoute" href="../php/rute.php">rute</a></li>
                    <li><a id="userTikets" href="../php/tiket.php?id=<?php echo isset($userDocument['id']) ? $userDocument['id'] : ''; ?>&search=<?php echo $search; ?>">tiket</a></li>
                    <script src="../javascript/mainer.js"></script>
                    <script src="../javascript/linker.js"></script>
                    <script src="../javascript/buser.js"></script>
                    <script src="../javascript/router.js"></script>
                    <script src="../javascript/tiketers.js"></script>
                </ul>
            </nav>
        </div>
        <div class="tiketnya">
            <form method="GET" action="../php/tiket.php">
                <input type="hidden" name="id" value="<?php echo isset($userDocument['id']) ? $userDocument['id'] : ''; ?>">
                <div class="search-bar">
                    <input type="text" name="search" placeholder="Cari tiket...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <br>
            <form action="../php/tiket.php?userid=<?php echo isset($userid) ? $userid : ''; ?>&" method="GET" class="filters">
                <label for="destination">Cari Daerah:</label>
                <select name="destination">
                    <?php
                    $provinces = array(
                        "Aceh",
                        "Bangka Belitung",
                        "Banten",
                        "Bengkulu",
                        "Gorontalo",
                        "DKI Jakarta",
                        "Jambi",
                        "Jawa Barat",
                        "Jawa Tengah",
                        "Jawa Timur",
                        "Kalimantan Barat",
                        "Kalimantan Selatan",
                        "Kalimantan Tengah",
                        "Kalimantan Timur",
                        "Kalimantan Utara",
                        "Kepulauan Riau",
                        "Lampung",
                        "Maluku",
                        "Maluku Utara",
                        "Nusa Tenggara Barat",
                        "Nusa Tenggara Timur",
                        "Papua",
                        "Papua Barat",
                        "Riau",
                        "Sulawesi Barat",
                        "Sulawesi Selatan",
                        "Sulawesi Tengah",
                        "Sulawesi Tenggara",
                        "Sulawesi Utara",
                        "Sumatera Barat",
                        "Sumatera Selatan",
                        "Sumatera Utara",
                        "Yogyakarta"
                    );

                    foreach ($provinces as $province) {
                        echo '<option value="' . $province . '">' . $province . '</option>';
                    }
                    ?>
                </select>
                <button type="submit">Group</button>
            </form>
            <ul class="tiketlist">
                <?php foreach ($documents as $document): ?>
                    <li>
                        <img class="tiket-image" src="../image/tiket.png" alt="tiket bang"/>
                        <span>ID: <?php echo $document["id"]; ?></span><br>
                        <span>ID Bus: <?php echo $document["busid"]; ?></span><br>
                        <span>Nama Supir: <?php echo $document["supirname"]; ?></span><br>
                        <span>Kontak Supir: <?php echo $document["supiremail"] . ", " . $document["supirnumber"]; ?></span><br>
                        <span>Nomor Kursi: <?php echo $document["chairnumber"]; ?></span><br>
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