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
$roomselected = $_SESSION['roomselected'];
$checkoutDI = date_create($_SESSION['bookinginfo']['checkout']);
$nights = $checkoutDI->diff(date_create($_SESSION['bookinginfo']['checkin']));
// Pull room data for selected room   
require('database.php');
$query1 = "SELECT *"
    . "        FROM rooms r"
    . "        WHERE r.roomNum = $roomselected";

$statement1 = $db->prepare($query1);
$statement1->execute();
$roomdata = $statement1->fetchAll(PDO::FETCH_ASSOC);
$roomdata = deArray($roomdata);
// roomdata = roomNum, roomType, beds, sleeps, rate, photo 


// Read form input
$fname= htmlspecialchars($_POST['form_fname']);
$lname= htmlspecialchars($_POST['form_lname']);
$email= htmlspecialchars($_POST['form_email']);
$phone= htmlspecialchars($_POST['form_phone']);

// Check if customer already in database
$query2 = "SELECT * FROM customers WHERE email = '$email' AND lname = '$lname'";
$statement2 = $db->prepare($query2);
$statement2->execute();
$customer = deArray($statement2->fetchALL(PDO::FETCH_ASSOC));

//echo var_dump($customer);

if (empty($customer)){   // if the customer is not currently in the db
    // add customer to db
    //echo "$fname $lname is not in our customer db <br>";
    $cinsert_query = "INSERT INTO customers (fname, lname, email, phone) VALUES ('$fname', '$lname', '$email', '$phone')";
    $cinsert_statement = $db->prepare($cinsert_query);
    $cinsert_statement->execute();
    
    // now pull our new customer's unique ID
    $cid_query = "SELECT clientid FROM customers WHERE lname = '$lname' AND email = '$email'";
    $cid_statement = $db->prepare($cid_query);
    $cid_statement->execute();
    $clientid = $cid_statement->fetchALL(PDO::FETCH_ASSOC);
    //echo '$clientid[0][0] is ' . $clientid[0][0] . '<br>';
    //echo "$clientid is " . $clientid . '<br>';
} else {
    $clientid = $customer[0];
    //echo "<br>$fname $lname was already in db as guest #$clientid";
}


// Record reservation into db

$res_query = "INSERT INTO reservations (guest, checkin, checkout, roomNum)
    VALUES ('$clientid', '$checkin', '$checkout', '$roomselected')";
$res_statement = $db->prepare($res_query);
$res_statement->execute();
$res_statement->closeCursor();
    
include('header.php') 
?>
<!-- Main content -->
            <div class="centered" style= "margin-bottom:25px;">
                <div class="roombg" style="background-image: url(.<?php echo $roomdata[5]?>); ">
                    
                
                    <div class="centered"  style="height:100%">
                        <div style="background-color: rgba(255,255,255,0.7); color: black; padding:20px; text-align:center;">
                            <h1>Thank you <?php echo $fname?>!</h1>
                            <h2 style="margin-top:0px;">Your room has been reserved!</h1>
                        
                            
                        <div class="finalinvoice">
                            <p style='font-size:12pt;'>
                        <span style="font-size:15pt; font-weight:800;">Room <?php echo "$roomselected"?></span>
                            <?php echo "<br>$roomdata[1]<br>Check In: " . date_format(date_create($_SESSION['bookinginfo']['checkin']),"D M d, Y")
                                    .'<br>Check Out: ' . date_format(date_create($_SESSION['bookinginfo']['checkout']),"D M d, Y") 
                                    . "<br>$totalguests" . ($totalguests>1 ? ' guests' : ' guest')
                                    . '<br> ' . $nights->format('%d') . ($nights->format('%d') > 1 ? ' nights' : ' night')
                                    . ' x $' . $roomdata[4] . '<br>' 
                                    . '<hr solid 1px style="margin:0px;"><br>'
                                    . '<p class="finalpriceinv"><em>$' . ($nights->format('%d')*$roomdata[4]) . '</em></p>'?>
                        
                            </p>
                        </div>
                            <div width="50" align="center" float="left">
                                <a href="index.php"><b>Return to Home</b></a>
                            </div>
                    </div>
                    </div>
                
                </div>
        
<!-- Footer --> 
        
               <?php
         include('footer.php');
        ?>