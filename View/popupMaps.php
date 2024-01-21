
<?php session_start();
include('header.php');?>
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
        <div id='myMap' style='width: 100vw; height: 100vh;'></div>
        <script type='text/javascript' >
            function loadMapScenario() {
                var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
                    credentials: 'Your_Bing_Maps_API_Key',
                    center: new Microsoft.Maps.Location(<?=$_REQUEST['adress1']?>, <?=$_REQUEST['adress2']?>)
,
                    zoom: 15
                });
                
                // Add a pushpin at the specified location
                var pushpin = new Microsoft.Maps.Pushpin(map.getCenter(), null);
                map.entities.push(pushpin);
            }
        </script>
        <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=ArPyVpvQwgEAtQEL8Bwn97dwL5PvXXdA-B9-rBSptdmvN4zUDV4QsU7v1IF24KQR&callback=loadMapScenario' async defer></script>
   

