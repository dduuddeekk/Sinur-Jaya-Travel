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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/listbus.css">
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
    </style>
</head>
<body>
    <h1>DAFTAR BUS</h1>
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