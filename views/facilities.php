<?php
include '../views/templates/header.php';
include '../views/templates/navbar.php';
include '../controllers/facilities.inc.php';

connectToDB();
$userType = checkUserType($GLOBALS['conn'], $_SESSION['username']);
$currUsername = $_SESSION['username'];
closeConnection();
?>

<main class="container pb-3">
    <div class="d-flex p-3 my-3 text-white bg-secondary rounded shadow-sm">
        <div class="lh-1">
            <h4 class="mb-0 text-white lh-1">Book a Facility</h4>
        </div>
    </div>
    <div class="my-3 p-3 bg-body rounded shadow-sm" style="text-align: initial">
        <div>
            <h5>
                Currently Booked

            </h5>
        </div>
        <hr />
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "baddelete") {
                echo "<p> Error In Deleting Booking </p><hr/>";
            } else if ($_GET["error"] == "none") {
                echo "<p> Successfully Deleted Booking </p><hr/>";
            }
        }
        ?>
        

        <?php
        connectToDB();
        getLaundryBookings($GLOBALS['conn']);
        getSaunaBookings($GLOBALS['conn']);
        getPoolBookings($GLOBALS['conn']);
        getGymBookings($GLOBALS['conn']);
        closeConnection();
        ?>
        <div>
            <h5>
                Currently Available
            </h5>
            <hr />

            <?php
            connectToDB();
            getAvailableLaundryBookings($GLOBALS['conn']);
            getAvailableSaunaBookings($GLOBALS['conn']);
            getAvailablePoolBookings($GLOBALS['conn']);
            getAvailableGymBookings($GLOBALS['conn']);
            closeConnection();
            ?>
        </div>

        <hr />
        <div>
            <h5>
                Your Bookings - Click to Delete
            </h5>
            <hr />

            <?php
            connectToDB();
            getUserLaundryBookings($GLOBALS['conn'], $currUsername);
            getUserSaunaBookings($GLOBALS['conn'], $currUsername);
            getUserPoolBookings($GLOBALS['conn'], $currUsername);
            getUserGymBookings($GLOBALS['conn'], $currUsername);
            closeConnection();
            ?>
        </div>
        <hr />
        <div>
            <h5>
                Book Here
            </h5>
            <hr />
            
            <form method="POST" action="../controllers/formHandler.inc.php" id="submitBooking">
                <table class="table profileTables">
                    <tbody>
                        <tr>
                            <th class="col-3" scope="row">Room ID</th>
                            <td><input type="text" name="roomID" class="form-control" id="floadingRoomID" placeholder="Room ID" required></td>
                        </tr>
                        <tr>
                            <th class="col-3" scope="row">Duration </th>
                            <td><input type="text" name="duration" class="form-control" id="floadingDuration" placeholder="Duration" required></td>
                        </tr>
                        <tr>
                            <th class="col-3" scope="row">Date</th>
                            <td><input type="text" name="date" class="form-control" id="floatingDate" placeholder="Date - YYYY/MM/DD" required></td>
                        </tr>

                    </tbody>
                </table>
        </div>
        <button class="register-btn w-100 btn btn-lg btn-success" type="submit" id="submitBooking" name="submitBooking" value="Submit" form="submitBooking">Submit Booking</button>
        </form>

    </div>

</main>

<link href="../css/application.css" rel="stylesheet">
<?php include('../views/templates/footer.php'); ?>