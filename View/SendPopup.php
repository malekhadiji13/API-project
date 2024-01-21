<?php
 $api_url2 = 'http://127.0.0.1:5000/GetAllusers';

 // Create HTTP headers
 $options2 = array(
     'http' => array(
         'header'  => "Content-type: application/json",
         'method'  => 'GET',
         
     ),
 );

 $context2  = stream_context_create($options2);

 $response2 = file_get_contents($api_url2, false, $context2);
 $data2 = json_decode($response2, true);

 $Users = $data2['users']; 
?>
   <!-- Modal -->
   <div class="modal fade" id="sendModal<?=$a[0]?>" tabindex="-1" role="dialog" aria-labelledby="sendModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendModalLabel">Send Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add your form fields here -->
                    <form action="AlertsPage.php?id=<?=$a[0]?>" method="POST">
                        <input type="hidden" name="id" value="<?= $a[0] ?>">
                        <label for="msg">Message:</label>
                        <textarea name="msg" class="form-control" rows="10" cols="200" readonly>
                             
                                <?php echo "Alert ID: {$a[0]}\nDetail: {$a[1]}\nAddress: {$a[6]}Citizens: {";
                                foreach ($listCitizens as $c){
                                
                                echo $c.',' ;
                            }
                            echo "}\nDate: {$a[5]}";
                                ?></textarea>
                        <br>
                        <label for="email">Email:</label>
                        <select name="email" class="form-control" required>
                        <?php
                        // Assume $Users is an array of users fetched from the GetAllUsers endpoint
                        foreach ($Users as $u) {
                     ?> 
                     <option value='<?=$u[2]?>'><?=$u[2]?></option>";
                     <?php
                        }
                        ?>
                    </select>

                        <!-- <input type="email" name="email" class="form-control" required> -->
                        <br>
                        <button type="submit" class="btn btn-primary" name="sendBtnModal">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>