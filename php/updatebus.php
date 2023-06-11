<?php
    include "../php/connect.php";

    $collection = $database->selectCollection("bus");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST["id"];
        $image = isset($_FILES["image"]) ? $_FILES["image"] : null;
        $plat = isset($_POST["plat"]) ? $_POST["plat"] : "";
        $jenis = isset($_POST["type"]) ? $_POST["type"] : ""; // Fix: Change "jenis" to "type"
        $kursi = isset($_POST["chair"]) ? intval($_POST["chair"]) : 0; // Fix: Change "kursi" to "chair"
        $status = isset($_POST["status"]) ? $_POST["status"] : "";

        $filter = [ "id" => $id ];
        $update = [ '$set' => [
            "plat" => $plat,
            "type" => $jenis, // Fix: Change "jenis" to "type"
            "chair" => $kursi, // Fix: Change "kursi" to "chair"
            "status" => $status
        ]];

        if ($image !== null && $image["error"] === UPLOAD_ERR_OK) {
            $tempFilePath = $image["tmp_name"];
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $destinationPath = '../image/busprofile/' . $id . '.' . $extension;
            move_uploaded_file($tempFilePath, $destinationPath);
            $update['$set']['image'] = $destinationPath; // Fix: Change "profile" to "image"
        }

        $result = $collection->updateOne($filter, $update);

        if ($result->getModifiedCount() > 0) {
            header("Location: ../php/listbus.php");
            exit();
        } else {
            echo "Update Failed";
        }
    }
?>