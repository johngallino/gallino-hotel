<?php include('header.php') ?>

        <div class="lightbox">
            <div class="bookbox">
 <!-- DATE PICKER ONLY WORKS IN CHROME --> 
            <form action="checkavailability.php" method="get" style="display:flex;">
                <div>
                    CHECK IN:<br>
                    <input type="date" min="<?php echo $today?>" name="check_in"  value="<?php echo $today?>">
                </div>
                    
                   
                <div>
                    CHECK OUT:<br>
                    <input type="date" min="<?php echo date_format($tomorrow,'Y-m-d')?>" name="check_out" value="<?php echo date_format($tomorrow, 'Y-m-d')?>">
                </div>
                    
                    <div>
                    ADULTS:<br>
                <select name="adults">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
                </div>
                
                <div>
                    KIDS:<br>
                <select name="kids">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
                </div>
               
                <div style="border-right:0px;">
                    <input type="submit" name="check_abv" value="CHECK AVAILABILITY">
                </div>
                
                </form>
                   <?php 
                        $fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        
                        if (strpos($fullURL, "wrongdates") == true){
                            echo "<p class='error'>Entered dates are invalid! Please check again.</p>";
                        }
                        else if (strpos($fullURL, "emptydates") == true){
                            echo "<p class='error'>Please fill in both fields.</p>";
                        }
                        ?>
                </div>
            </div>
        </div>
        
        <?php
         include('footer.php');
        ?>
