<?php
include "../php/connect.php";

$collection = $database->selectCollection("supir");

$id = isset($_POST["id"]) ? $_POST["id"] : "";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/updatebus.css">
    <title>PERBARUI BUS</title>
</head>
<body>
    <h1>PERBARUI BUS</h1>
    <form action="../php/updatesupir.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <label for="image">Foto:</label>
        <input type="file" name="image" />
        <label for="name">Nama:</label>
        <input type="text" name="name">
        <label for="age">Umur:</label>
        <input type="number" name="age">
        <label for="address">Alamat:</label>
        <input type="text" name="address">
        <label for="email">Email:</label>
        <input type="text" name="email">
        <label for="number">Telepon:</label>
        <input type="text" name="number">
        <label for="status">Status:</label>
        <select name="status">
            <option value="active">active</option>
            <option value="inactive">inactive</option>
        </select>
        <button type="submit">PERBARUI</button>
        <a href="javascript:history.back()" class="button-cancel">BATAL</a>
    </form>
</body>
</html>