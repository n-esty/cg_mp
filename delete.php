<?php
    session_start();
    include('includes/connect_db.php');
    include('includes/ad_service.php');
    $adinfo = [];
    
    function deleteAd() {   
        echo $_GET['id'];
         
    }
    
    
    switch($_GET['type']) {
        case 'ad':
        $adService = new AdService($pdo, $adinfo);
        $deleteAd = $adService->deleteAd();
        if($deleteAd){
            header("location: index.php");
        }
        break;
    }

        
        
        
        
        
        
        
        
       // if(is_array($placeAd)){
      //      extract($placeAd);
     //   } elseif ($placeAd) {
    //       header("location: show_ad.php?ad=$placeAd");
   //     }
?>