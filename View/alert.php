<?php

$api_url = 'http://127.0.0.1:5000/GetAllalerts';

// Create HTTP headers
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\nAuthorization: Bearer malek123",
        'method'  => 'GET',
    ),
);

$context  = stream_context_create($options);

$response = file_get_contents($api_url, false, $context);
$data = json_decode($response, true);

$Alerts = $data['alerts']; // Output the response

// Your existing PHP code...

try {
    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        // Sanitize the input to prevent security issues
        $id = intval($_GET['id']);

        // Append the ID to the API URL
        $api_url .= '?id=' . $id;
        echo "<h2>" .  $id . "</h2>";
        // Create HTTP headers
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\nAuthorization: Bearer malek123",
                'method'  => 'GET',
            ),
        );

        $context  = stream_context_create($options);

        // Make a GET request to the API
        $response = file_get_contents($api_url, false, $context);
        $data = json_decode($response, true);

        // Check if the response contains the required information
        if (isset($data['alertAdress'])) {
            $alertAdress = $data['alertAdress'];

            // Extract latitude and longitude as before
            list($address, $coordinates) = explode("(", $alertAdress);
            list($latitude, $longitude) = explode(",", rtrim($coordinates, ")"));

            // Now you can pass these values to your JavaScript code
            echo "<script>
                    var langitude = {$latitude};
                    var largitude = {$longitude};

                    function loadMapScenario() {

                        var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
                            credentials: 'ArPyVpvQwgEAtQEL8Bwn97dwL5PvXXdA-B9-rBSptdmvN4zUDV4QsU7v1IF24KQR',
                            center: new Microsoft.Maps.Location(langitude, largitude)
        ,
                            zoom: 15
                        });
                        
                        // Add a pushpin at the specified location
                        var pushpin = new Microsoft.Maps.Pushpin(map.getCenter(), null);
                        map.entities.push(pushpin);
                    }
                  </script>";
        } else {
            echo "No record found for the given ID.";
        }
    } else {
        echo "ID parameter not provided.";
    }
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Alert page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style type='text/css'>body{margin:0;padding:0;overflow:hidden;font-family:'Segoe UI',Helvetica,Arial,Sans-Serif}</style>

    <link rel="stylesheet" href="3.css">

</head>

<body>
    <div class="container" style="padding-top: 100px; ">
        <h1 class="my-4">Alert</h1>
        <table class="table">
            <thead  >
                <tr  >
                    <th scope="col">id</th>
                    <th scope="col">Detail Alert</th>
                    <th scope="col">Address</th>
                    <th scope="col">Citizens</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach($Alerts as $a) :
$adress =substr($a[5],strpos($a[5],'('),strpos($a[5],')'));    ?>

<tr>
                    <th scope="row"><?=$a[0]?></th>
                    <td><?=$a[1]?> </td>
                    <td><?= $a[5]?><br><a id="changeButton" href="map_page.html" style="color:#57557A;font-weight: bold;" data-toggle="modal" data-target="#exampleModal">View Map</a></td>
                    <td><?=$a[3]?></td>
                    <td><?=$a[4]?></td>
                    <!-- popup send -->
    <td>
        <button class="btn btn-link" data-id="1" data-toggle="modal" data-target="#sendModal">Send</button>
    </td>

    <!-- Modal -->
    <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="sendModalLabel" aria-hidden="true">
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
                    <form action="AlertsPage.php" method="POST">
                        <input type="hidden" name="id" value="<?= $a[0] ?>">
                        <label for="msg">Message:</label>
                        <textarea name="msg" class="form-control" readonly><?= "Alert ID: {$a[0]}\nDetail: {$a[1]}\nAddress: {$a[5]}\nCitizens: {$a[3]}\nDate: {$a[4]}" ?></textarea>
                        <br>
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-primary" name="sendBtnModal">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <div id='printoutPanel'></div>
        
        <div id='myMap' style='width: 100vw; height: 100vh;'></div>
        
        <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=ArPyVpvQwgEAtQEL8Bwn97dwL5PvXXdA-B9-rBSptdmvN4zUDV4QsU7v1IF24KQR&callback=loadMapScenario' async defer></script>
   
        </div>
    </div>
  </div>
</div>
                </tr>
                
                <?php endforeach;
?> </tbody>
        </table>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#changeButton').on('click', function() {
            
            // Change the ID in the URL to the desired value (e.g., 2)
            var newId = 2;
            var newUrl = window.location.href.split('?')[0] + '?id=' + newId;
            window.history.pushState({path: newUrl}, '', newUrl);

            // Reload the page or make an AJAX request to fetch data for the new ID
            location.reload(); // or your AJAX request here
        });
    });
</script>
</html>
