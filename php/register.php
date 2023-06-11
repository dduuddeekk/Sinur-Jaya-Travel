<?php
    include "../php/connect.php";

    $collectionName = "users";
    $collectionNames = $database->listCollectionNames();
    $collectionExist = in_array($collectionName, iterator_to_array($collectionNames));
    $collection = null;

    if ($collectionExist) {
        $collection = $database->selectCollection($collectionName);
    } else {
        $collection = $database->createCollection($collectionName);
    }

    $randomNumber = mt_rand(1, 99999999);
    $paddedNumber = str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
    $id = "PNP" . $paddedNumber;
    $name = $_POST["name"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $status = "active";

    $hash = hash("sha256", $password);

    $document = [
        "id" => $id,
        "name" => $name,
        "address" => $address,
        "email" => $email,
        "number" => $number,
        "username" => $username,
        "password" => $hash,
        "status" => $status
    ];

    $result = $collection->insertOne($document);

    if ($result) {
        header("Location: ../html/regsuccess.html");
        exit();
    } else {
        echo "Failed.";
    }
?>