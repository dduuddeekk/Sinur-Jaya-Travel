<?php
    include "../php/connect.php";

    $collectionName = "tiket";
    $collectionNames = $database->listCollectionNames();
    $collectionExist = in_array($collectionName, iterator_to_array($collectionNames));
    $collection = null;

    if ($collectionExist) {
        $collection = $database->selectCollection($collectionName);
    } else {
        $collection = $database->createCollection($collectionName);
    }

    $busid = $_POST["busid"];
    $userid = $_POST["userid"];
    $destination = $_POST["destination"];
    $supirid = $_POST["supirid"];
    $date = $_POST["date"];

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

    $busCollection = $database->selectCollection("bus");

    $tempid = $busid;
    $busDocument = $busCollection->find(["id" => $tempid]);

    foreach ($busDocument as $bus){
        $type = $bus['type'];
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

    $supirId = null;
    $supirNama = null;
    $supirEmail = null;
    $supirNumber = null;

    $supirCollection = $database->selectCollection("supir");

    $pipeline = [
        ['$sample' => ['size' => 1]]
    ];

    $options = [];

    $cursor = $supirCollection->aggregate($pipeline, $options);
    $randomSupirDocument = $cursor->toArray();

    if (!empty($randomSupirDocument)) {
        $supirId = $randomSupirDocument[0]->id;
        $supirNama = $randomSupirDocument[0]->name;
        $supirEmail = $randomSupirDocument[0]->email;
        $supirNumber = $randomSupirDocument[0]->number;
    } else {
        echo "Tidak ada supir yang aktif.";
    }

    $id = generateTiketId();

    $query = [
        "id" => $id,
        "busid" => $busid,
        "supirid" => $supirId,
        "supirname" => $supirNama,
        "supiremail" => $supirEmail,
        "supirnumber" => $supirNumber,
        "userid" => $userid,
        "destination" => $destination,
        "date" => $date,
        "price" => $price
    ];

    $document = $collection->insertOne($query);

    if($document){
        header("Location: ../php/tiketsuccess.php?id=$userid");
        exit();
    }else{
        echo "Something went wrong.";
    }

    function generateTiketId() {
        $randomNumber = mt_rand(1, 99999999);
        $paddedNumber = str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
        return "TKT" . $paddedNumber;
    }
?>