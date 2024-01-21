
<?php
session_start();
if(!isset($_SESSION['id'])){

    header("Location: loginPage.php");

    }
$api_url = 'http://127.0.0.1:5000/GetAllalerts';

// Create HTTP headers
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json",
        'method'  => 'GET',
        
    ),
);

$context  = stream_context_create($options);

$response = file_get_contents($api_url, false, $context);
$data = json_decode($response, true);

$Alerts = $data['alerts'];
$citizens = $data["citizens"];// Output the response

    $api_url_send = 'http://127.0.0.1:5000/send';
    $api_url_send1 = 'http://127.0.0.1:5000/UpdateStatus';

if (isset($_POST['sendBtnModal']) && isset($_POST['msg']) && isset($_POST['email'])&& isset($_REQUEST['id'])) {
    // Handle the modal form submission
    $data = array('msg' => $_POST['msg'], 'email' => $_POST['email']);
    $id = array('idAlert' => $_REQUEST['id']);

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );
    $options1 = array(
        'http' => array(
            'header'  => "Content-type: application/json",
            'method'  => 'PUT',
            'content' => json_encode($id),
        ),
    );
    $context1  = stream_context_create($options1);
    $response1 = file_get_contents($api_url_send1, false, $context1);

    $context  = stream_context_create($options);
    $response = file_get_contents($api_url_send, false, $context);

    if (strpos($response, "sent")) {
        echo $response;
        header("Location: AlertsPage.php");
        exit();
    } else {
        $error = $response;
    }   
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Law enforcement</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

 
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  
</head>

<body>
    <?php include('header.php');?>

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
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>

                <?php $i=0;
                foreach($Alerts as $a) :
                    $i++;
$adress1 =floatval(substr($a[6],strpos($a[6],'(')+1,strpos($a[6],',')+1)) ;   
$adress2 =floatval(substr($a[6],strpos($a[6],$adress1)+strlen($adress1)+2,strpos($a[6],')')+1));    ?>

<tr>
                    <th scope="row"><?=$a[0]?></th>
                    <td><?=$a[1]?> </td>
                    <td><?=substr($a[6],0,strpos($a[6],$adress1)-1)?> 
                        <br><a href="popupMaps.php?adress1=<?=$adress1?>&adress2=<?=$adress2?>" style="color:#57557A;font-weight: bold;" >View Map</a></td>
                    <td><?php
                    $listCitizens = array();
                    foreach($citizens[$i] as $c) : 
                     foreach(
                            $c as $id
                     ):
                     echo $id.'<br>';
                    array_push($listCitizens,$id);
                    endforeach;endforeach;?></td>

                    <td><?=$a[5]?></td>
                    
    <td>
        <button class="btn btn-link" data-id="1" data-toggle="modal" data-target="#sendModal<?=$a[0]?>">Send</button>
    </td>
    <td class="text-center">
    <?php if ($a[2] == 'sent') : ?>
        <img src="sent.png" alt="Sent Icon" width="25" height="25">
    <?php endif; ?>
</td>

 <?php include("SendPopup.php");
 endforeach;?>

                </tr>
                
                 </tbody>
        </table>
    </div>
</body>
</html>
