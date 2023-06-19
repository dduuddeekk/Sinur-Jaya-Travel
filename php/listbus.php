<?php
include "../php/connect.php";

$collection = $database->selectCollection("bus");
$documents = null;
$group = isset($_GET["group"]) ? $_GET["group"] : "";
$status = isset($_GET["status"]) ? $_GET["status"] : "";

if ($group == "MICRO") {
    $documents = $collection->find(["type" => "MICRO"]);
} else if ($group == "MEDIUM") {
    $documents = $collection->find(["type" => "MEDIUM"]);
} else if ($group == "BIG") {
    $documents = $collection->find(["type" => "BIG"]);
} else {
    $documents = $collection->find();
}

if ($status == "inactive") {
    $documents = $collection->find(["status" => "inactive"]);
} else if ($group == "MEDIUM") {
    $documents = $collection->find(["status" => "active"]);
} else {
    $documents = $collection->find();
}

$isEmpty = $collection->estimatedDocumentCount() === 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idToDelete = $_POST["delete"];
    $collection->deleteOne(["id" => $idToDelete]);
    header("Location: ../php/listbus.php");
    exit();
}

// Sorting buses by chair count
$sortKey = isset($_GET["sort"]) ? $_GET["sort"] : "";
$sortOptions = [];

if ($sortKey === "chair") {
    $sortOptions = ["chair" => 1]; // Urutan naik (kecil ke besar)
}

$queryOptions = [];
if (!empty($sortOptions)) {
    $queryOptions['sort'] = $sortOptions;
}

$searchKeyword = isset($_GET["search"]) ? $_GET["search"] : "";
$filteredDocuments = [];

if (!empty($searchKeyword)) {
    $filter = [
        '$or' => [
            ["id" => ['$regex' => $searchKeyword, '$options' => 'i']],
            ["plat" => ['$regex' => $searchKeyword, '$options' => 'i']],
            ["type" => ['$regex' => $searchKeyword, '$options' => 'i']],
            ["chair" => ['$regex' => $searchKeyword, '$options' => 'i']],
            ["status" => ['$regex' => $searchKeyword, '$options' => 'i']]
        ]
    ];

    $filteredDocuments = $collection->find($filter, $queryOptions);
} else {
    $filteredDocuments = $documents;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/listbus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <title>DAFTAR BUS</title>
    <style>
        .bus-group {
            margin-bottom: 20px;
        }

        .bus-group-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .bus-list {
            margin-left: 20px;
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

        .tambah button{
            background-color: #fcd733;
            border: 1px solid #fcd733;
            color: aliceblue;
            font-size: 20px;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .group-form{
            font-family: "Roboto", sans-serif;
            text-align: center;
            color: black;
            font-size: 20px;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .group-form button{
            background-color: #fcd733;
            border: 1px solid #fcd733;
            color: aliceblue;
            font-size: 20px;
            padding: 7px 10px;
            border-radius: 5px;
        }

        .group-form select{
            border: 1px solid #fcd733;
            padding: 7px 10px;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <h1>DAFTAR BUS</h1>
    <div class="searchbar">
        <form action="../php/listbus.php" method="GET">
            <input type="text" name="search" placeholder="Cari bus ...." value="<?php echo $searchKeyword; ?>">
            <button type="submit" class="fas fa-search"></button>
        </form>
    </div>
    <form action="../html/adminindex.html">
        <button type="submit" class="kembali-button">KEMBALI</button>
    </form>
    <form action="../html/addbus.html" class="tambah">
        <button type="submit">TAMBAH</button>
    </form>

    <?php if ($isEmpty): ?>
        <p class="empty-message">Belum Ada Bus Yang Terdaftar</p>
    <?php else: ?>
        <div class="group-form">
            <form action="../php/listbus.php" method="get">
                <label for="group">Tipe Bus:</label>
                <select name="group" id="group">
                    <option value="null">None</option>
                    <option value="MICRO">MICRO</option>
                    <option value="MEDIUM">MEDIUM</option>
                    <option value="BIG">BIG</option>
                </select>
                <button type="submit">Group</button>
            </form>

            <form action="../php/listbus.php" method="get">
                <label for="status">Status Aktif:</label>
                <select name="status" id="status">
                    <option value="null">None</option>
                    <option value="inactive">Tidak Aktif</option>
                    <option value="active">Aktif</option>
                </select>
                <button type="submit">Group</button>
            </form>

            <div class="sort-button-container">
                <span>Urutkan berdasarkan:</span>
                <a href="?sort=chair" class="sort-button">Kursi</a>
            </div>
        </div>

        <?php foreach ($filteredDocuments as $document): ?>
            <div class="bus-group">
                <ul class="bus-list">
                    <li>
                        <?php if (isset($document["image"])): ?>
                            <img src="<?php echo $document["image"]; ?>" alt="Bus Image" class="bus-image">
                        <?php endif; ?>
                        <span>ID: <?php echo $document["id"]; ?></span>
                        <span>Plat: <?php echo $document["plat"]; ?></span>
                        <span>Jenis: <?php echo $document["type"]; ?></span>
                        <span>Kursi: <?php echo $document["chair"]; ?></span>
                        <span>Status: <?php echo $document["status"]; ?></span>
                        <form method="POST" onsubmit="return confirm('YAKIN?')">
                            <input type="hidden" name="delete" value="<?php echo $document["id"]; ?>">
                            <button type="submit">HAPUS</button>
                        </form>
                        <form action="../php/getbus.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $document["id"]; ?>">
                            <button type="submit">PERBARUI</button>
                        </form>
                    </li>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>
