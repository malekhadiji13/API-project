
<?php
session_start();
if(isset($_SESSION['id'])){

// destroy the session
session_destroy();
}
$api_url = 'http://127.0.0.1:5000/login';
if(isset($_REQUEST['email']) && isset($_REQUEST['pass']))
{
// Data to be sent in the POST request
$data = array('email' => $_REQUEST['email'], 'password' => $_REQUEST['pass']);

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
$response = json_decode(file_get_contents($api_url, false, $context));
// Output the response
if(str_contains($response->status,"success")){
  $_SESSION['id']=$response->id[0];
  $_SESSION['name']=$response->id[1];
  header("Location: AlertsPage.php");

}else{
  $error = $response;
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="3.css">
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 </head>
 
  <div class="login-box">
  <?php
    if(isset($error)){echo '<div class="alert alert-danger" role="alert">
      '.$error.'</div>';}?>
    <h2>Login</h2>
    <form action="loginPage.php" method="POST">
      <div class="user-box">
        <input type="text" name="email" required="">
        <label>Email Address</Address></label>
      </div>
      <div class="user-box">
        <input type="password" name="pass" required="">
        <label>Password</label>
      </div>
    <a href="#" style=" position: relative ; left: 117px; bottom: 30px;   font-family: sans-serif;">  

      <button type="submit" >  
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      SUBMIT
      </button>
    </a>
    </form>
  </div>
</html>