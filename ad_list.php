<?php
    session_start();
    include('includes/connect_db.php');
    include('includes/ad_service.php');
    $adinfo = [];
    $adService = new AdService($pdo, $adinfo);
    $adList = $adService->adList();
    echo $adList;
    ?>