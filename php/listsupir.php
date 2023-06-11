<?php
include "../php/connect.php";

$collection = $database->selectCollection("supir");

$isEmpty = $collection->countDocuments() === 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idToDelete = $_POST["delete"];
    $collection->deleteOne(["id" => $idToDelete]);
    header("Location: ../php/listsupir.php");
    exit();
}

// Sorting logic
$sortKey = isset($_GET["sort"]) ? $_GET["sort"] : "";
$sortOptions = [];

if ($sortKey === "name") {
    $sortOptions = ["name" => 1];
} elseif ($sortKey === "age") {
    $sortOptions = ["age" => 1];
}

$queryOptions = [];
if (!empty($sortOptions)) {
    $queryOptions['sort'] = $sortOptions;
}

$documents = $collection->find([], $queryOptions);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/listbus.css">
    <title>DAFTAR SUPIR</title>
    <style>
        .sort-button-container {
            text-align: center;
            margin-bottom: 10px;
        }

        .sort-button {
            background-color: #fcd773;
            color: white;
            border: none;
            padding: 5px 10px;
            margin-right: 10px;
            cursor: pointer;
        }

        .sort-button:hover {
            background-color: #f9c611;
        }
    </style>
</head>
<body>
    <h1>DAFTAR SUPIR</h1>
    <form action="../html/adminindex.html">
        <button type="submit" class="kembali-button">KEMBALI</button>
    </form>
    <form action="../html/addsupir.html" class="tambah">
        <button type="submit">TAMBAH</button>
    </form>
    <div class="sort-button-container">
        <span>Urutkan berdasarkan:</span>
        <a href="?sort=name" class="sort-button">Nama</a>
        <a href="?sort=age" class="sort-button">Umur</a>
    </div>
    <?php if ($isEmpty): ?>
        <p class="empty-message">Belum Ada Supir Yang Terdaftar</p>
    <?php else: ?>
        <ul class="bus-list">
            <?php foreach ($documents as $document): ?>
                <li>
                    <?php if (isset($document["image"])): ?>
                        <img src="<?php echo $document["image"]; ?>" alt="Bus Image" class="bus-image">
                    <?php endif; ?>
                    <span>ID: <?php echo $document["id"]; ?></span>
                    <span>Nama: <?php echo $document["name"]; ?></span>
                    <span>Umur: <?php echo $document["age"]; ?></span>
                    <span>Alamat: <?php echo $document["address"]; ?></span>
                    <span>Email: <?php echo $document["email"]; ?></span>
                    <span>Telepon: <?php echo $document["number"]; ?></span>
                    <span>Status: <?php echo $document["status"]; ?></span>
                    <form method="POST" onsubmit="return confirm('YAKIN?')">
                        <input type="hidden" name="delete" value="<?php echo $document["id"]; ?>">
                        <button type="submit">HAPUS</button>
                    </form>
                    <form action="../php/getsupir.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $document["id"]; ?>">
                        <button type="submit">PERBARUI</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>