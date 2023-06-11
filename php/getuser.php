<?php
    include "../php/connect.php";
    $collection = $database->selectCollection("users");
    $id = isset($_POST["id"]) ? $_POST["id"] : "";
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/updateuser.css" />
    <title>PERBARUI AKUN</title>
</head>
<body>
    <h1>PERBARUI AKUN</h1>
    <form action="updateuser.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="password" value="<?php echo $password; ?>">
        <label for="image">Foto:</label>
        <input type="file" name="image" />
        <label for="name">Nama:</label>
        <input type="text" name="name">
        <label for="address">Alamat:</label>
        <input type="text" name="address">
        <label for="number">Nomor Telepon:</label>
        <input type="text" name="number">
        <div class="button-container">
            <button type="submit">SIMPAN</button>
            <a href="javascript:history.back()" class="button-cancel">BATAL</a>
        </div>
    </form>
</body>
</html>