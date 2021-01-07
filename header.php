<!DOCTYPE html>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Hotel Gallino - Welcome</title>
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One|Libre+Baskerville">
        <link rel="stylesheet" type="text/css" href="gstyle.css">
        <?php date_default_timezone_set("America/New_York");
        $today=date("Y-m-d");
        $tomorrow = new DateTime('tomorrow');
        require('database.php');
?>
        
    </head>
    <body>
        <div class="main">
            <h1 class="header"><a href="index.php">Hotel Gallino</a></h1>
            <nav>
                <div class="centered">
                <ul>
                    <li><a href="history.php">HISTORY</a></li>
                    <li><a href="dining.php">DINING</a></li>
                    
                    <li><a href="bar.php">BAR</a></li>
                    <li><a href="rooms.php">ROOMS & SUITES</a></li>  
                    
                </ul>
                </div>
            </nav>
        </div>
        
