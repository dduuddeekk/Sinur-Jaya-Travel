<?php
    include "../php/connect.php";
    $busid = $_POST["busid"];
    $userid = $_POST["userid"];
    $destination = $_POST["destination"];
    $supirid = $_POST["supirid"];
    $date = $_POST["date"];

    $busCollection = $database->selectCollection("bus");
    $busDocument = $busCollection->findOne(["id" => $busid]);

    $chairNumber = $busDocument["chair"];

    $sumatra = array(
        "Aceh",
        "Sumatera Utara",
        "Sumatera Barat",
        "Riau",
        "Kepulauan Riau",
        "Jambi",
        "Sumatera Selatan",
        "Bangka Belitung",
        "Bengkulu",
        "Lampung"
    );
    $jawa = array(
        "DKI Jakarta",
        "Jawa Barat",
        "Jawa Tengah",
        "DI Yogyakarta",
        "Jawa Timur",
        "Banten"
    );
    $nusaTenggara = array(
        "Nusa Tenggara Barat",
        "Nusa Tenggara Timur"
    );
    $kalimantan = array(
        "Kalimantan Barat",
        "Kalimantan Tengah",
        "Kalimantan Selatan",
        "Kalimantan Timur",
        "Kalimantan Utara"
    );
    $sulawesi = array(
        "Sulawesi Utara",
        "Gorontalo",
        "Sulawesi Tengah",
        "Sulawesi Barat",
        "Sulawesi Selatan",
        "Sulawesi Tenggara"
    );
    $maluku = array(
        "Maluku",
        "Maluku Utara"
    );
    $papua = array(
        "Papua",
        "Papua Barat"
    );

    // Mengupdate Bus Ketika Pembelian Tiket.
    $getBusPlat = $busDocument["plat"];
    $getBusType = $busDocument["type"];
    $getBusStatus = $busDocument["status"];
    $getBusImage = $busDocument["image"];

    $filterBus = ["id" => $busid];
    $queryBus = [
        '$set' => [
            "plat" => $getBusPlat,
            "type" => $getBusType,
            "chair" => $chairNumber - 1,
            "status" => $getBusStatus,
            "image" => $getBusImage
        ]
    ];

    $resultBus = $busCollection->updateOne($filterBus, $queryBus);
?>