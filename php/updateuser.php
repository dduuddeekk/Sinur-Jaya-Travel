<?php
    include "../php/connect.php";
    $collection = $database->users;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST["id"];
        $username = $_POST["username"];
        $gambar = $_FILES["image"];
        $nama = isset($_POST["name"]) ? $_POST["name"] : "";
        $alamat = isset($_POST["address"]) ? $_POST["address"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $nomor = isset($_POST["number"]) ? $_POST["number"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";

        $filter = [ "id" => $id ];
        $update = [
            '$set' => [
                "profile" => $gambar,
                "name" => $nama,
                "address" => $alamat,
                "email" => $email,
                "number" => $nomor,
                "username" => $username,
                "password" => $password 
            ]
        ];

        // Handle the uploaded file
        if ($gambar["error"] === UPLOAD_ERR_OK) {
            $tempFilePath = $gambar["tmp_name"];
            $extension = pathinfo($gambar["name"], PATHINFO_EXTENSION);
            $destinationPath = '../image/userprofile/' . $id . '.' . $extension;
            move_uploaded_file($tempFilePath, $destinationPath);
            $update['$set']['profile'] = $destinationPath;
        }        

        $result = $collection->updateOne($filter, $update);

        if ($result->getModifiedCount() > 0) {
            header("Location: ../php/user.php?username=$username");
            exit();
        } else {
            echo "id = " . $id . "<br>";
            echo "username = " . $username . "<br>";
            echo "gambar = " . $gambar . "<br>";
            echo "nama = " . $nama . "<br>";
            echo "alamat = " . $alamat . "<br>";
            echo "email = " . $email . "<br>";
            echo "nomor = " . $nomor . "<br>";
            echo "Update Failed";
        }
    }
?>