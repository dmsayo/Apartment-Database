<?php
require_once 'connection.inc.php';
require_once 'functions.inc.php';
require_once 'login.inc.php';
require_once 'register.inc.php';
require_once 'editProfile.inc.php';
require_once 'facilities.inc.php';

connectToDB();
session_start(); // start session to store needed user info
if (isset($_POST['loginSubmit'])) { /* Login */
    loginHandler();
} else if (isset($_POST['registerSubmit'])) { /* Sign up */
    registerHandler();
} else if (isset($_POST['editProfileSubmit'])) { /* Edit Profile */
    editProfileHandler();
} else if (isset($_POST['submitBooking'])) { /* Edit Profile */
    facilitiesHandler();
}
closeConnection();
