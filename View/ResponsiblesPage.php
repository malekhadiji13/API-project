
<?php
session_start();

if(!isset($_SESSION['id'])){

  header("Location: loginPage.php");

  }
$api_url = 'http://127.0.0.1:5000/GetAllusers';

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

$Users = $data['users'];// Output the response

if(isset($_REQUEST['id']) && isset($_REQUEST['btnDelete'])){
    $data = array('id' => $_REQUEST['id']);
    $api_url = 'http://127.0.0.1:5000/Delete';
    
// Create HTTP headers
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json",
        'method'  => "DELETE",
        'content' => json_encode($data),
        
    ),
);

$context  = stream_context_create($options);

$response = file_get_contents($api_url, false, $context);
if(str_contains($response,"deleted")){
    header("Location: ResponsiblesPage.php");
  
  }else{
   print_r($response);
  }
}
?>

<?php
$api_url = 'http://127.0.0.1:5000/AddUser';

if(isset($_REQUEST['confirmBtn']) && isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['pass']) && isset($_REQUEST['role']))
{
    // Data to be sent in the POST request
    $data = array('name' => $_REQUEST['name'], 'email' => $_REQUEST['email'], 'password' => $_REQUEST['pass'], 'role' => $_REQUEST['role']);

    // Create HTTP headers
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context  = stream_context_create($options);

    // Make POST request
    $response = file_get_contents($api_url, false, $context);

    // Output the response
    if(strpos($response, "success") !== false){
        header("Location: ResponsiblesPage.php");
        exit(); // add this line to stop executing further code after redirection
    } else {
        $error = $response;
    }
}

if(isset($_REQUEST['confirmBtn']) && isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['id']))
{$api_url = 'http://127.0.0.1:5000/UpdateInfo';

    // Data to be sent in the PUT request
    $data = array( 'id' => $_REQUEST['id'],'name' => $_REQUEST['name'], 'email' => $_REQUEST['email'], 'password' => $_REQUEST['password']);

    // Create HTTP headers
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json",
            'method'  => 'PUT',
            'content' => json_encode($data),
        ),
    );

    $context  = stream_context_create($options);

    // Make PUT request
    $response = file_get_contents($api_url, false, $context);

    // Output the response
    if(strpos($response, "affected") !== false){
        header("Location: ResponsiblesPage.php");
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
        <h1 class="my-4">Manage law enforcement</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Name </th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($Users as $u) :  ?>

                <tr>
                    <th scope="row"><?=$u[0]?></th>
                    <td><?=$u[1]?></td>
                    <td><?=$u[2]?></td>
                    <!--<td><?=$u[3]?></td>-->
                    <td><?=$u[4]?></td>
                    <td><button class="btn btn-link "  data-toggle="modal" data-target="#editModal<?=$u[0]?>">Edit</button>
                    <form action="ResponsiblesPage.php?id=<?=$u[0]?>" method="POST">
                    <button type="submit" class="btn btn-link send-button" data-id="1" name="btnDelete" >Remove</button></form></td>
                </tr>
               <!-- popup edit -->
               <?php        $editName = $u[1];  $editEmail = $u[2];
        $editPassword = $u[3];
 include("popupEdit.php"); ?>
                <?php endforeach;
?> </tbody>
        </table>
        
    </div>
    <!-- Button trigger modal -->
<button type="button" class="btn btn-link " data-toggle="modal" data-target="#exampleModal" style="position: relative;top: -35px; left:600px;border: 1.8px solid white;
  border-radius: 5px;">
  Add
</button> 

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fill this form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="ResponsiblesPage.php" method="POST">
      <div class="user-box">
        <input type="text" name="name" required>
        <label>Name</label>
      </div>
      <div class="user-box">
        <input type="text" name="email" required>
        <label>Email Address</Address></label>
      </div>
      <div class="user-box">
        <input type="password" name="pass" required>
        <label>Password</label>
      </div>
      <div class="user-box">
        <select name="role" id="role" required>
        <?php
        $uniqueRoles = array_unique(array_column($Users, 4));
        foreach ($uniqueRoles as $role) {
          echo "<option value='$role'>$role</option>";
        }
        ?>
        </select>
        <label>Role</label>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="confirmBtn">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>
