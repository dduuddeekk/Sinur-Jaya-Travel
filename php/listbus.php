<?php
include "../php/connect.php";

$collection = $database->selectCollection("bus");
$documents = $collection->find();
$isEmpty = $collection->estimatedDocumentCount() === 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idToDelete = $_POST["delete"];
    $collection->deleteOne(["id" => $idToDelete]);
    header("Location: ../php/listbus.php");
    exit();
}

// Grouping buses by type
$groupedBuses = [];
foreach ($documents as $document) {
    $type = $document["type"];
    if (!array_key_exists($type, $groupedBuses)) {
        $groupedBuses[$type] = [];
    }
    $groupedBuses[$type][] = $document;
}

// Sorting buses by chair count
$sortKey = isset($_GET["sort"]) ? $_GET["sort"] : "";
if ($sortKey === "chair") {
    foreach ($groupedBuses as &$busGroup) {
        usort($busGroup, function ($a, $b) {
            return $a["chair"] - $b["chair"];
        });
    }
}

$searchKeyword = isset($_GET["search"]) ? $_GET["search"] : "";
$filteredDocuments = [];

if (!empty($searchKeyword)) {
    $filter = ['$or' => [
        ["id" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["plat" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["type" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["chair" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["status" => ['$regex' => $searchKeyword, '$options' => 'i']]
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/listbus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
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
        <form action="../php/listbus.php" method="get" class="group-form">
            <label for="group">Group by:</label>
            <select name="group" id="group">
                <option value="">None</option>
                <?php foreach ($groupedBuses as $type => $busGroup): ?>
                    <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Group</button>
        </form>

        <div class="sort-button-container">
            <span>Sort by:</span>
            <a href="?sort=chair" class="sort-button">Chair</a>
        </div>

        <?php foreach ($groupedBuses as $type => $busGroup): ?>
            <div class="bus-group">
                <h2 class="bus-group-title"><?php echo $type; ?></h2>
                <ul class="bus-list">
                    <?php foreach ($busGroup as $document): ?>
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
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>