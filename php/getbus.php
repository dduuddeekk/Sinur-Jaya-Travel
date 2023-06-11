<?php
    include "../php/connect.php";

    $collection = $database->selectCollection("bus");

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
    <form action="../php/updatebus.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="image">Foto:</label>
        <input type="file" name="image" />
        <label for="plat">Nomor STNK:</label>
        <input type="text" name="plat">
        <label for="type">Jenis:</label>
        <select name="type">
            <option value="BIG">BIG</option>
            <option value="MEDIUM">MEDIUM</option>
            <option value="MICRO">MICRO</option>
        </select>
        <label for="chair">Kursi:</label>
        <input type="number" name="chair">
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