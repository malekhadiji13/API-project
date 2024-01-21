
<?php
session_start();

if(!isset($_SESSION['id'])){

  header("Location: loginPage.php");

  }
$api_url = 'http://127.0.0.1:5000/GetUserById';
$data = array('user_id' => $_SESSION['id']);

// Create HTTP headers
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json",
        'method'  => 'GET',
        'content' => json_encode($data),

    ),
);

$context  = stream_context_create($options);

$response = file_get_contents($api_url, false, $context);
$data = json_decode($response, true);

$User = $data;// Output the response



if(isset($_REQUEST['confirmBtn']) && isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['pass']) )
{$api_url = 'http://127.0.0.1:5000/UpdateInfo';

    // Data to be sent in the POST request
    $data = array( 'id' => $_SESSION['id'],'name' => $_REQUEST['name'], 'email' => $_REQUEST['email'], 'password' => $_REQUEST['pass']);

    // Create HTTP headers
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json",
            'method'  => 'PUT',
            'content' => json_encode($data),
        ),
    );

    $context  = stream_context_create($options);

    // Make POST request
    $response = file_get_contents($api_url, false, $context);

    // Output the response
    if(strpos($response, "success") !== false){
        header("Location: AccountPage.php");
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

    <div class="container" style="padding-top: 100px">
        <h1 class="my-4">My Account</h1>
        <?php foreach ($User as $u) : 
        ?>
        <!-- Display user information for Admin role -->
        <div id="account-info" style=" padding-left:400px;">
 <h5 style="color:white;">Name: <span id="name"><?=$u[1]?></span></h5>
 <h5 style="color:white;">Email: <span id="email"><?=$u[2]?></span></h5>
 <button class="btn btn-link "  data-toggle="modal" data-target="#editModal">Edit</button>
              <!-- popup edit -->
              <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit this form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="AccountPage.php" method="POST">
      <div class="user-box" >
        
      <input type="text" name="name" value="<?=$u[1]?>" required>
      <label >Name</label>

      </div>
      <div class="user-box">
      <input type="text" name="email" value="<?=$u[2]?>" required>
      <label>Email Address</label>
      </div>
      <div class="user-box">
      <input type="password" name="pass" required>
      <label>Edit or enter Password</label>
      </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="confirmBtn">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>    </div>
</div
<?php endforeach; ?>
        
        
  
    
</body>
</html>
