<?php
    require '../controllers/connection.inc.php'; // relative to where this file is being used
    require '../controllers/navbar.inc.php';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <?php
            connectToDB();
            session_start();
            $userType = checkUserType($GLOBALS['conn'], $_SESSION['username']);
            setNavbarView($GLOBALS['conn'], $_SESSION['username'], $userType);
            closeConnection();
        ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['username']; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class='dropdown-item' href='../views/profile.php'>Profile</a></li>
                        <li><a class="dropdown-item" href="../">Logout</a></li>
                    </ul>
                </li>
                <?php
                    if ($userType === "tenant") {
                        // Add more tenant navbar items here
                        echo '<li class="nav-item"><a class="nav-link" href="../views/facilities.php">Facility Booking</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="../views/gym.php">Gym Information</a></li>';
                    } else if ($userType === "landlord") {
                        // Add more landlord navbar items here
                        // echo '<li class="nav-item"><a class="nav-link" href="#">Add/Delete Tenants</a></li>';
                    }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="../views/aboutViewPage.php">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>