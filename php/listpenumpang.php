<?php
include "../php/connect.php";

$collection = $database->selectCollection("users");

$isEmpty = $collection->countDocuments() === 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idToDelete = $_POST["delete"];
    $collection->deleteOne(["id" => $idToDelete]);
    header("Location: ../php/listpenumpang.php");
    exit();
}

$documents = $collection->find();

$searchKeyword = isset($_GET["search"]) ? $_GET["search"] : "";
$filteredDocuments = [];

if (!empty($searchKeyword)) {
    $filter = ['$or' => [
        ["id" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["name" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["address" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["email" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["number" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["username" => ['$regex' => $searchKeyword, '$options' => 'i']]
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
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
    <h1>DAFTAR PENUMPANG</h1>
    <div class="searchbar">
        <form action="../php/listpenumpang.php" method="GET">
            <input type="text" name="search" placeholder="Cari penumpang ...." value="<?php echo $searchKeyword; ?>">
            <button type="submit" class="fas fa-search"></button>
        </form>
    </div>
    <form action="../html/adminindex.html">
        <button type="submit" class="kembali-button">KEMBALI</button>
    </form>
    <?php if ($isEmpty): ?>
        <p class="empty-message">Belum Ada Penumpang Yang Terdaftar</p>
    <?php else: ?>
        <ul class="bus-list">
            <?php foreach ($filteredDocuments as $document): ?>
                <li>
                    <?php if (isset($document["image"])): ?>
                        <img src="<?php echo $document["image"]; ?>" alt="Bus Image" class="bus-image">
                    <?php endif; ?>
                    <span>ID: <?php echo $document["id"]; ?></span>
                    <span>Nama: <?php echo $document["name"]; ?></span>
                    <span>Alamat: <?php echo $document["address"]; ?></span>
                    <span>Email: <?php echo $document["email"]; ?></span>
                    <span>Telepon: <?php echo $document["number"]; ?></span>
                    <span>Username: <?php echo $document["username"]; ?></span>
                    <form method="POST" onsubmit="return confirm('YAKIN?')">
                        <input type="hidden" name="delete" value="<?php echo $document["id"]; ?>">
                        <button type="submit">HAPUS</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>