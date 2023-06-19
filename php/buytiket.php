<?php
    include "../php/connect.php";
    $busid = $_POST["busid"];
    $userid = $_POST["userid"];
    $destination = $_POST["destination"];
    $supirid = $_POST["supirid"];
    $date = $_POST["date"];
    $maksnumber = intval($_POST["makschair"]);

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

    $price = 0;

    $type = $busDocument["type"];
    switch($type){
        case 'BIG':
            $price = 200000;
            break;
        case 'MEDIUM':
            $price = 100000;
            break;
        case 'MICRO':
            $price = 50000;
            break;
        default:
            $price = 0;
            break;
    }

    if(in_array($destination, $jawa) || in_array($destination, $nusaTenggara)){
        $price *= 1.5;
    }else if(in_array($destination, $sumatra)){
        $price *= 2;
    }else if(in_array($destination, $kalimantan)){
        $price *= 3;
    }else if(in_array($destination, $sulawesi)){
        $price *= 3.5;
    }else if(in_array($destination, $maluku) || in_array($destination, $papua)){
        $price *= 4;
    }

    $collection = $database->selectCollection("tiket");
    $searchSupirDocument = $collection->find(["supirid" => $supirid]);

    $foundSupir = false;
    foreach ($searchSupirDocument as $doc) {
        if ($doc["supirid"] == $supirid && $doc["busid"] != $busid && $doc["date"] != $date) {
            $foundSupir = true;
            break;
        } else if ($doc["supirid"] == $supirid && $doc["busid"] == $busid && $doc["date"] != $date) {
            $foundSupir = true;
            break;
        }
    }

    if ($foundSupir) {
        header("Location: ../php/errormessagetiket.php?busid=$busid&userid=$userid");
        exit();
    } else {
        $result = null;
        $resultBus = null;
        $temp = 1;
        while ($temp <= $maksnumber) {
            $supirCollection = $database->selectCollection("supir");
            $supirDocument = $supirCollection->findOne(["id" => $supirid]);

            $id = generateTiketId();

            $tiketQuery = [
                "id" => $id,
                "busid" => $busid,
                "supirid" => $supirid,
                "supirname" => $supirDocument["name"],
                "supiremail" => $supirDocument["email"],
                "supirnumber" => $supirDocument["number"],
                "userid" => $userid,
                "chairnumber" => $chairNumber,
                "destination" => $destination,
                "date" => $date,
                "price" => $price
            ];

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
            $result = $collection->insertOne($tiketQuery);

            $temp += 1;
            $chairNumber -= 1;
        }

        if($result != null){
            if($resultBus != null){
                header("Location: ../php/tiketsuccess.php?id=$userid");
                exit();
            }else{
                header("Location: ../php/errormessagetiket.php?busid=$busid&userid=$userid");
                exit();
            }
        }else{
            header("Location: ../php/errormessagetiket.php?busid=$busid&userid=$userid");
            exit();
        }
    }

    function generateTiketId() {
        $randomNumber = mt_rand(1, 99999999);
        $paddedNumber = str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
        return "TKT" . $paddedNumber;
    }
?>