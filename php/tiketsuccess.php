<?php
include "../php/connect.php";
$collection = $database->selectCollection("users");

$id = $_GET["id"];
$document = $collection->findOne(["id" => $id]);

if (!$document) {
    echo "Dokumen tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BERHASIL</title>
    <style>
        body {
            background-color: aliceblue;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        
        h1 {
            color: #fcd733;
            font-family: 'Roboto', sans-serif;
        }
        
        img {
            width: 200px;
            margin-bottom: 20px;
        }
        
        a.button {
            color: #fcd733;
            font-family: 'Roboto', sans-serif;
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            background-color: transparent;
            border: 2px solid #fcd733;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        a.button:hover {
            background-color: #fcd733;
            color: aliceblue;
        }
        
        a.button:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <h1>PEMBELIAN BERHASIL</h1>
    <div>
        <img src="../image/benar.jpg" alt="Success Image">
    </div>
    <a href="../php/userindex.php?username=<?php echo urlencode($document["username"]); ?>" class="button">Kembali</a>
</body>
</html>