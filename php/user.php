<?php
    include "../php/connect.php";
    $collection = $database->users;

    $document = null;

    if (isset($_GET["username"])) {
        $username = $_GET["username"];

        $query = [
            "username" => $username
        ];

        $document = $collection->findOne($query);
    }

    function escape($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/user.css">
    <title>PROFIL</title>
</head>
<body>
    <a href="../php/userindex.php" class="back-button" id="userMain">Kembali</a>
    <script src="../javascript/mainer.js"></script>
    <h1>Profil</h1>
    <?php if ($document): ?>
        <ul class="bus-list">
            <li>
                <span>ID: <?php echo escape($document["id"]); ?></span>
                <?php if (!empty($document["profile"])): ?>
                    <img src="<?php echo escape($document['profile']); ?>" alt="Profile Image" />
                <?php endif; ?>
                <span>Nama: <?php echo escape($document["name"]); ?></span>
                <span>Username: <?php echo escape($document["username"]); ?></span>
                <span>Alamat: <?php echo escape($document["address"]); ?></span>
                <span>Nomor HP: <?php echo escape($document["number"]); ?></span>
                <span>Email: <?php echo escape($document["email"]); ?></span>

                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this document?')">
                    <input type="hidden" name="delete" value="<?php echo escape($document["id"]); ?>">
                    <button type="submit">Hapus Akun</button>
                </form>
                <form action="../php/getuser.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo escape($document["id"]); ?>">
                    <input type="hidden" name="username" value="<?php echo escape($document["username"]); ?>">
                    <input type="hidden" name="email" value="<?php echo escape($document["email"]); ?>">
                    <input type="hidden" name="password" value="<?php echo escape($document["password"]); ?>">
                    <button type="submit">Perbarui</button>
                </form>
                <form action="../php/index.php">
                    <button type="submit">Keluar</button>
                </form>
            </li>
        </ul>
    <?php else: ?>
        <p>Data profil tidak ditemukan.</p>
    <?php endif; ?>
</body>
</html>