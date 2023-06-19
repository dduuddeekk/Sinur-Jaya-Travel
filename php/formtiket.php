<?php
    include "../php/connect.php";
    $busid = isset($_GET["busid"]) ? $_GET["busid"] : "";
    $userid = isset($_GET["userid"]) ? $_GET["userid"] : "";

    $busCollection = $database->selectCollection("bus");
    $busDocument = $busCollection->findOne(["id" => $busid]);

    $maksnumber = 0;

    $maksnumber = $busDocument["chair"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/formtiket.css">
    <title>BELI TIKET</title>
</head>
<body>
    <div class="ticketform">
        <h1>PEMBELIAN TIKET</h1>
        <form action="../php/buytiket.php" method="POST">
            <input type="hidden" name="busid" value="<?= htmlspecialchars($busid) ?>">
            <input type="hidden" name="userid" value="<?= htmlspecialchars($userid) ?>">
            <label for="destination">Tujuan:</label>
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
            <label for="supirid">Pilih Supir:</label>
            <select name="supirid">
                <?php
                    include "../php/connect.php";
                    $supirCollection = $database->selectCollection("supir");
                    $supirDocuments = $supirCollection->find();

                    foreach ($supirDocuments as $supirDocument){
                        echo '<option value="' . $supirDocument["id"] . '">' . $supirDocument["name"] . ' ' . '(' . $supirDocument["age"] . ')' . '</option>';
                    }
                ?>
            </select>
            <label for="date">Tanggal Berangkat:</label>
            <input type="date" name="date" required>
            <label for="makschair">Jumlah Tiket:</label>
            <input type="number" name="makschair" min="1" max="<?= $maksnumber ?>" required>
            <button type="submit">Beli Tiket</button>
        </form>
        <a href="javascript:history.back()" class="button-cancel">BATAL</a>
    </div>
</body>
</html>