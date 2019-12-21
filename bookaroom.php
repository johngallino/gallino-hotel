<?php
function deArray($array){
    $newArray = array();
    foreach ($array as $subarray){
        foreach($subarray as $val){
            array_push($newArray, $val);
        }
    }
    return $newArray;
}

// Pull session data
session_start();
$checkin = $_SESSION['bookinginfo']['checkin'];
$checkout = $_SESSION['bookinginfo']['checkout'];
$adults = $_SESSION['bookinginfo']['adults'];
$kids = $_SESSION['bookinginfo']['kids'];
$totalguests = $_SESSION['bookinginfo']['totalguests'];
$fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$urlarray = str_split($fullURL);
$pos = strpos($fullURL, 'rmnum');
$roomselected = '';
foreach ($urlarray as $char) {  //pulls selected room number out of URL
    if (is_numeric($char)){
        $roomselected .= $char;
    }
        }
$_SESSION['roomselected'] = $roomselected;
$checkoutDI = date_create($_SESSION['bookinginfo']['checkout']);
$nights = $checkoutDI->diff(date_create($_SESSION['bookinginfo']['checkin']));
// Pull room data for selected room   
require('database.php');
$query1 = "SELECT *"
    . "        FROM rooms r"
    . "        WHERE r.roomNum = :roomselected";

$statement1 = $db->prepare($query1);
$statement1->bindValue(':roomselected', $roomselected);
$statement1->execute();
$roomdata = $statement1->fetchAll(PDO::FETCH_ASSOC);
$roomdata = deArray($roomdata);
// roomdata = roomNum, roomType, beds, sleeps, rate, photo 
$statement1->closeCursor();
include('header.php') ?>
<!-- Main content -->
            <div class="centered" style= "margin-bottom:25px;">
                <div class="roombg" style="background-image: url(.<?php echo $roomdata[5]?>); ">
                    
                
                    <div class="centered"  style="height:100%">
                        <div style="position: relative; background-color: rgba(255,255,255,0.7); color: black; padding:20px;">
                            <h1 style="margin-top:0px;">Let's get your information...</h1>
                        <form action="complete.php" method="post" id="customerform">
                            <label>First name</Label></br>
                            <input type="text" name="form_fname" required></br>
                            <label>Last name</Label></br>
                            <input type="text" name="form_lname" required><br>
                            <label>Email</Label></br>
                            <input type="email" name="form_email" required><br>
                            <label>Phone</Label></br>
                            <input type="tel" name="form_phone" required><br>
                        
                            
                        <div class="charges">
                            <p style='font-size:12pt; text-align:right; right:25px; top:10px;'>
                        <span style="font-size:15pt; font-weight:800;">Room <?php echo "$roomselected"?></span>
                            <?php echo "<br>$roomdata[1]<br>Check In: " . date_format(date_create($_SESSION['bookinginfo']['checkin']),"D M d, Y")
                                    .'<br>Check Out: ' . date_format(date_create($_SESSION['bookinginfo']['checkout']),"D M d, Y") 
                                    . "<br>$totalguests" . ($totalguests>1 ? ' guests' : ' guest')
                                    . '<br> ' . $nights->format('%d') . ($nights->format('%d') > 1 ? ' nights' : ' night')
                                    . ' x $' . $roomdata[4] . '<br>' 
                                    . '<hr solid 1px style="margin:0px;"><br>'
                                    . '<p class="finalprice"><em>$' . ($nights->format('%d')*$roomdata[4]) . '</em></p>'?>
                        
                            </p>
                            <input style="clear:both; margin-left:200px;" type="submit" value="Book It!" name="bookresbutton">
                        </div>
                            </form>
                    </div>
                    </div>
                
                </div>
        
<!-- Footer --> 
        
               <?php
         include('footer.php');
        ?>