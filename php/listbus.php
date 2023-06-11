<?php
    include "../php/connect.php";

    $collection = $database->selectCollection("bus");
    $documents = $collection->find();
    $isEmpty = $documents->count() === 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idToDelete = $_POST["delete"];
        $collection->deleteOne(["id" => $idToDelete]);
        header("Location: ../php/listbus.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/listbus.css">
    <title>DAFTAR BUS</title>
</head>
<body>
    <h1>DAFTAR BUS</h1>
    <form action="../php/adminindex.php">
        <button type="submit" class="kembali-button">KEMBALI</button>
    </form>
    <form action="../html/addbus.html" class="tambah">
        <button type="submit">TAMBAH</button>
    </form>
    <?php if ($isEmpty): ?>
        <p class="empty-message">Belum Ada Bus Yang Terdaftar</p>
    <?php else: ?>
        <ul class="bus-list">
            <?php foreach ($documents as $document): ?>
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
    <?php endif; ?>
</body>
</html>