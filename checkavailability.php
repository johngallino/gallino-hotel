<?php
date_default_timezone_set("America/New_York");
$d=strtotime("tomorrow");
require('database.php');
$lifetime = strtotime('24 hours');
session_set_cookie_params($lifetime);
session_start();
$check_in = htmlspecialchars($_GET['check_in']);
$check_out = htmlspecialchars($_GET['check_out']);
$adults = htmlspecialchars($_GET['adults']);
$kids = htmlspecialchars($_GET['kids']);
$totalguests = $adults + $kids;

$_SESSION['bookinginfo'] = array();
$_SESSION['bookinginfo']['checkin'] = $check_in;
$_SESSION['bookinginfo']['checkout'] = $check_out;
$_SESSION['bookinginfo']['adults'] = $adults;
$_SESSION['bookinginfo']['kids'] = $kids;
$_SESSION['bookinginfo']['totalguests'] = $totalguests;


//remember to filter input
$inputrepeat = 'You entered ' . $adults . ($adults > 1 ? ' adults' : ' adult') .($kids > 0 ? " and $kids" : '') . ($kids > 1 AND $kids !==0 ? ' kids': ' child') . ' to check in on ' . date_format(date_create($check_in), "D, M d, Y") . ' and check out on ' . date_format(date_create($check_out), "D, M d, Y")  . '<br>';

if (date_create($check_in) >= date_create($check_out)){ // Check if checkin date is before checkout date
    header("Location: index.php?error=wrongdates");
}
else if (empty($check_in) || empty($check_in)){
    header("Location: index.php?error=emptydates");
}

function deArray($array){
    $newArray = array();
    foreach ($array as $subarray){
        foreach($subarray as $val){
            array_push($newArray, $val);
        }
    }
    return $newArray;
}


//my check in is NOT before their check out AND my check out is not after their check in
// my check in is on or after their check out AND my check out is on or before their check in
$query1 = "SELECT r.roomNum"
    . "        FROM rooms r"
    . "        WHERE r.sleeps >= :total_guests";

$statement1 = $db->prepare($query1);
$statement1->bindValue(':total_guests', $totalguests);
$statement1->execute();
$roomresults = $statement1->fetchAll(PDO::FETCH_ASSOC);
$roomresults = deArray($roomresults);

$query2 = "SELECT roomNum from reservations "
        . "WHERE (:checkin BETWEEN checkin and checkout)"
        . "OR (:checkout BETWEEN checkin and checkout)";
$statement2 = $db->prepare($query2);
$statement2->bindValue(':checkin', $check_in);
$statement2->bindValue(':checkout', $check_out);
$statement2->execute();
$nogood = $statement2->fetchALL(PDO::FETCH_ASSOC);
$nogood = deArray($nogood);

$availableRooms = array_diff($roomresults, $nogood);
$arString = join(', ', $availableRooms);

$query3 = "SELECT * from rooms WHERE roomNum IN ($arString)";
$statement3 = $db->prepare($query3);
$statement3->execute();
$availableRoomDetails = $statement3->fetchAll(PDO::FETCH_ASSOC);
$statement3->closeCursor(); 

$howmany = sizeof($availableRooms);

// DEBUG CITY
//echo 'arString is ' . $arString . '<br>';
//echo 'check_in is ' . $check_in . '<br>';
//echo 'check_out is ' . $check_out . '<br>';
//echo '<br>roomresults is: ';
//foreach($roomresults as $val){
//                            echo $val;
//                            
//echo ', ';}
//
//echo '<br>nogood is: ';
//foreach($nogood as $val){
//                            echo $val;
//                            
//echo ', ';}
//
//echo '<br>availableRooms is: ';
//foreach($availableRooms as $val){
//                            echo $val;
//                            
//echo ', ';}
//
//echo '<br>availableRoomDetails is: <br>';
////SELECT * from rooms WHERE roomNum is IN ($arString)
//foreach($availableRoomDetails as $val){
//                            echo implode(', ', $val);
//                            
//echo '<br> ';}

// END DEBUG CITY
?>

<?php include('header.php') ?>
<!-- Main content -->
            <div class="centered" style="margin-bottom:25px;">
                <div class="queryresult">
                    <?php echo $inputrepeat;
                     if ($howmany !== 0){
                     echo "<br>We have $howmany" . ($howmany >1 ? ' rooms':' room') . " available at that time!";
                     
                     }
                     else {
                     echo "Sorry, we have no vacancies at that time!";
                     
                     };?>
                </div>
            
                
                <div class="centered" style="flex-flow: row wrap;">
            <?php foreach($availableRoomDetails as $room):?>
                    <div class="roombox" >
                        <div class="overlayText">
                            <div style="padding:15px;">
                                <h1 style="margin:0px; font-size:18pt;"><?php echo 'Room ' . $room['roomNum']?> </h1>
                                <h3  style="margin:0px; font-size:10pt;"><?php echo $room['roomType'] . '   (Sleeps ' . $room['sleeps'].')'?></h3>
                                <form action="bookaroom.php" method="get"j style="margin:0px;">
                                <input style="position:absolute; top:33px; right:15px;" type="submit" value="Book Now" name="<?php echo 'rmnum' . $room['roomNum']?>">
                                </form>
                                <p class="price"><em> Starting at $<?php echo $room['rate']?> a night</em></p>
                            </div>
                        </div>
                             <img width="100% cover" src="/<?php echo 'gallino_hotel' . $room['photo']?>">
                    </div>
            <?php endforeach; ?>
                    
                    </div>
            </div>
           </center>

        </div>
        </div>
        
<!-- Footer --> 
        <?php
         include('footer.php');
        ?>