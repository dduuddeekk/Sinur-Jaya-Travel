<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Gagal</title>
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
    <?php
        include "../php/connect.php";
        $busid = $_GET["busid"];
        $userid = $_GET["userid"];
    ?>
    <h1>PEMBELIAN GAGAL</h1>
    <img src="../image/sedih.png">
    <h2>Terjadi Sebuah Kesalahan!</h2>
    <p>Supir sedang sibuk atau bus sedang sibuk.</p>
    <form action="../php/formtiket.php?busid=<?php echo $busid; ?>&userid=<?php echo $userid ?>">
        <button class="button">KEMBALI</button>
    </form>
</body>
</html>