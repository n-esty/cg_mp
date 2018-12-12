<?php
    session_start();
    $title = $description = $askingPrice = "";
    $title_err = $description_err = $askingPrice_err = "";
    if(isset($_POST["place"]))
    {
        include('connect_db.php');
        include('ad_service.php');
        $adinfo = array(
        'title'=>$_POST['title'],
        'description'=>$_POST['description'],
        'askingPrice'=>$_POST['askingPrice']
        );
        $adService = new AdService($pdo, $adinfo);
        $placeAd = $adService->submitNewAd();
        if(is_array($placeAd)){
            extract($placeAd);
        } elseif ($placeAd) {
           header("location: show_ad.php?ad=$placeAd");
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Place Ad</title>
         <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    </head>
    <body>
        <div class="wrapper">
            <h2>Place Ad</h2>
            <p>Please fill this form to place a new ad.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                    <span class="help-block"><?php echo $title_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                    <label>Description</label>
                    <textarea name="description" rows="10" class="form-control" ><?php echo $description; ?></textarea>
                    <span class="help-block"><?php echo $description_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($askingPrice_err)) ? 'has-error' : ''; ?>">
                    <label>Asking price</label>
                    <input type="text" name="askingPrice" class="form-control" value="<?php echo $askingPrice; ?>">
                    <span class="help-block"><?php echo $askingPrice_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="place" class="btn btn-primary" value="Place Ad">
                </div>
            </form>
        </div>
    </body>
</html>
