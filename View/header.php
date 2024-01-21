<style>
    

    .navbar {
        background-color: #007bff; /* Set a background color for the navigation bar */
        padding: 15px 0; /* Add padding to the top and bottom of the navigation bar */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow for depth */
    }

    .navbar-nav {
        margin: 0 auto; /* Center the navigation links */
    }

    .nav-link {
        color: #57557A!important; /* Set the text color for the navigation links */
        margin-right: 15px; /* Add spacing between the navigation links */
        font-weight:bold;
    }

    .navbar-text {
        margin-left: 15px; /* Add spacing between the navigation links and the "Logout" text */
        font-weight:bold;
    }

    .navbar-text a {
        color: #57557A !important; /* Set the text color for the "Logout" link */
    }
</style>  

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="mx-auto">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="AlertsPage.php">See Alerts <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ResponsiblesPage.php">Manage Responsibles</a>
                </li>
            </ul>
        </div>
        <span class="navbar-text">
            <a class="nav-link" href="AccountPage.php"><i class="fas fa-user"></i> <?=   $_SESSION['name']."'s account"
?></a>
        </span>
        <span class="navbar-text">
            <a class="nav-link" href="LoginPage.php">Logout</a>
        </span>
    </div>
</nav>
</header>