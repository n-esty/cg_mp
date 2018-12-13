<?php
    session_start();
    include('connect_db.php');
    include('ad_service.php');
    $adinfo = [];
    $adService = new AdService($pdo, $adinfo);
    $adList = $adService->adList();
    echo $adList;
    ?>