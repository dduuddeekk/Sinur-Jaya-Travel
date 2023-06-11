<?php
    include "../php/connect.php";

    $collection = $database->selectCollection("supir");

    $document = $collection->find();

    $isEmpty = $documents->count() === 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idToDelete = $_POST["delete"];
        $collection->deleteOne(["id" => $idToDelete]);
        header("Location: ../php/listsupir.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/listbus.css">
    <title>DAFTAR SUPIR</title>
</head>
<body>
    <h1>DAFTAR SUPIR</h1>
    <form action="../html/adminindex.html">
        <button type="submit" class="kembali-button">KEMBALI</button>
    </form>
    <form action="../html/addsupir.html" class="tambah">
        <button type="submit">TAMBAH</button>
    </form>
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