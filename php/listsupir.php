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

$searchKeyword = isset($_GET["search"]) ? $_GET["search"] : "";
$filter = [];

if (!empty($searchKeyword)) {
    $filter = ['$or' => [
        ["id" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["name" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["age" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["address" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["email" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["number" => ['$regex' => $searchKeyword, '$options' => 'i']],
        ["status" => ['$regex' => $searchKeyword, '$options' => 'i']]
    ]];
}

$group = isset($_GET["group"]) ? $_GET["group"] : "";

if($group == "inactive") $documents = $collection->find(["status" => $group]);
else if($group == "active") $documents = $collection->find(["status" => $group]);
else $documents = $collection->find($filter, $queryOptions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/listbus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <title>DAFTAR SUPIR</title>
    <style>
        .sort-button-container {
            text-align: center;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .sort-button {
            background-color: #fcd773;
            color: white;
            border: none;
            padding: 5px 10px;
            margin-right: 10px;
            cursor: pointer;
        }

        .sort-button-container select{
            border: 1px solid #fcd733;
            padding: 7px 10px;
            font-size: 20px;
        }

        .sort-button-container button{
            background-color: #fcd733;
            border: 1px solid #fcd733;
            color: aliceblue;
            font-size: 20px;
            padding: 7px 10px;
            border-radius: 5px;
        }

        .sort-button:hover {
            background-color: #fcd733;
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
    </style>
</head>
<body>
    <h1>DAFTAR SUPIR</h1>
    <div class="searchbar">
        <form action="../php/listsupir.php" method="GET">
            <input type="text" name="search" placeholder="Cari supir ...." value="<?php echo $searchKeyword; ?>">
            <button type="submit" class="fas fa-search"></button>
        </form>
    </div>
    <form action="../html/adminindex.html">
        <button type="submit" class="kembali-button">KEMBALI</button>
    </form>
    <form action="../html/addsupir.html" class="tambah">
        <button type="submit">TAMBAH</button>
    </form>
    <div class="sort-button-container">
        <form action="../php/listsupir.php" method="GET">
        <label for="group">Status:</label>
        <select name="group">
            <option value="null">None</option>
            <option value="inactive">Tidak Aftif</option>
            <option value="active">Aktif</option>
        </select>
        <button type="submit">Group</button>
        </form>
        <br>
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