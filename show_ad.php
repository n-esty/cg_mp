<?php
    session_start();
    include('includes/connect_db.php');
    include('includes/ad_service.php');
    $adinfo = [];
    $adService = new AdService($pdo, $adinfo);
    $showAd = $adService->showAd();
    if(!is_array($showAd)){
        header("location: place_ad.php");
    }
    ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Show Ad</title>
         <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    </head>
    <body>
        <div class="wrapper">
            <h2>Advertentie: <?php echo $showAd['title'] ?></h2>
            <p><strong>Specificatie:</strong><br><?php echo $showAd['description'] ?></p>
            <p><strong>Vraag prijs:</strong><br><?php echo $showAd['asking_price'] ?></p>
             <a href="delete.php?type=ad&id=<?php echo $_GET['ad'] ?>" name="delete" class="btn btn-default">Delete</a>
        </div>
    </body>
</html>
