<?php
    include "../php/connect.php";

    $collectionName = "supir";
    $collectionNames = $database->listCollectionNames();
    $collectionExist = in_array($collectionName, iterator_to_array($collectionNames));
    $collection = null;

    if ($collectionExist) {
        $collection = $database->selectCollection($collectionName);
    } else {
        $collection = $database->createCollection($collectionName);
    }

    $id = generateSupirId();
    $image = $_FILES["image"];
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $age = isset($_POST["age"]) ? intval($_POST["age"]) : 0; 
    $address = isset($_POST["address"]) ? $_POST["address"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $number = isset($_POST["number"]) ? $_POST["number"] : ""; 
    $status = "active";

    $query = [
        "id" => $id,
        "name" => $name,
        "age" => $age,
        "address" => $address,
        "email" => $email,
        "number" => $number,
        "status" => $status
    ];

    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $image = $_FILES["image"];
        $tempFilePath = $image["tmp_name"];
        $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
        $destinationPath = '../image/driverprofile/' . $id . '.' . $extension;
        move_uploaded_file($tempFilePath, $destinationPath);
        $query['image'] = $destinationPath;
    }

    try {
        $document = $collection->insertOne($query);

        if ($document) {
            header("Location: ../php/listsupir.php");
            exit();
        } else {
            echo "Something went wrong.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    function generateSupirId() {
        $randomNumber = mt_rand(1, 99999999);
        $paddedNumber = str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
        return "SPR" . $paddedNumber;
    }
?>