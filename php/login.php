<?php
    include "../php/connect.php";
    $collection = $database->selectCollection("users");

    $username = "";
    $password = "";

    if (isset($_GET["username"]) && isset($_GET["password"])) {
        $username = $_GET["username"];
        $password = $_GET["password"];
        $hash = hash("sha256", $password);

        $query = [
            "username" => $username,
            "password" => $hash
        ];

        $result = $collection->findOne($query);

        $id = $result["id"];

        if ($result) {
            if ($username === "admin" && $hash === "240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9") {
                header("Location: ../html/adminindex.html");
                exit();
            } else {
                header("Location: ../php/userindex.php?id=$id");
                exit();
                // echo "Berhasil.";
            }
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Username and password are required.";
    }
?>