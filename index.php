<?php
session_start();
?>
<html>
<head>
   <meta charset="UTF-8">
        <title>Show Ad</title>
         <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <script>
        var currentUser = "<?php echo $_SESSION['user_id'] ?>";
        var userName = "<?php echo $_SESSION['username'] ?>";
        </script>
    </head>
    <body>
        <div class="wrapper">
        <h2 id="title"></h2>
<div id="container">
    <table id="tbl" style="width:100%" border="1"><tr><th style="cursor:pointer" onclick="loadPage('title', this)" class="title">title</th><th style="cursor:pointer" onclick="loadPage('description', this)" class="description">description</th><th style="cursor:pointer" onclick="loadPage('asking_price', this)" class="asking price">asking price</th><th style="cursor:pointer" onclick="loadPage('', this)" class="datum">datum &#9660</th></tr>
    <tbody id="contenttable">
    </tbody>
    </table>
    </div>
    </div>
    
    <script src="mp.js"></script>
</body>
</html>