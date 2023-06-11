<?php
include "../php/connect.php";

$collection = $database->selectCollection("supir");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST["id"];
    $image = isset($_FILES["image"]) ? $_FILES["image"] : null;
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $age = isset($_POST["age"]) ? intval($_POST["age"]) : 0; 
    $address = isset($_POST["address"]) ? $_POST["address"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $number = isset($_POST["number"]) ? $_POST["number"] : ""; 
    $status = isset($_POST["status"]) ? $_POST["status"] : "";

    $filter = [ "id" => $id ];
    $update = [ '$set' => [
        "name" => $name,
        "age" => $age,
        "address" => $address,
        "email" => $email,
        "number" => $number,
        "status" => $status
    ]];

    if ($image !== null && $image["error"] === UPLOAD_ERR_OK) {
        $tempFilePath = $image["tmp_name"];
        $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
        $destinationPath = '../image/driverprofile/' . $id . '.' . $extension;
        move_uploaded_file($tempFilePath, $destinationPath);
        $update['$set']['image'] = $destinationPath;
    }

    $result = $collection->updateOne($filter, $update);

    if ($result->getModifiedCount() > 0) {
        header("Location: ../php/listsupir.php");
        exit();
    } else {
        echo "id = " . $id . "<br>";
        echo "name = " . $name . "<br>";
        echo "age = " . $age . "<br>";
        echo "address = " . $address . "<br>";
        echo "email = " . $email . "<br>";
        echo "number = " . $number . "<br>";
        echo "status = " . $status . "<br>";
        echo "Update Failed";
    }
}
?>