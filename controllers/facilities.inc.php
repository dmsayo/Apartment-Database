<?php
require_once 'connection.inc.php';
require_once 'functions.inc.php';
require_once 'navbar.inc.php';
require_once 'tenant.inc.php';

// Get currently booked laundry room info
function getLaundryBookings($conn)
{
    $sql = "SELECT distinct b.FacilityRoomID as RoomID, b.Duration as Duration, b.BookingDATE as Date FROM book b, facilities f WHERE b.FacilityRoomID = f.RoomID AND f.RoomID like '_01'";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p> Laundry room " . $row['RoomID'] . " reserved for " . $row['Duration'] . " hours on " . $row['Date'] . "</p>";
    }
    return $row;
}
// Get currently booked pool room info
function getPoolBookings($conn)
{
    $sql = "SELECT distinct b.FacilityRoomID as RoomID, b.Duration as Duration, b.BookingDATE as Date FROM book b, facilities f WHERE b.FacilityRoomID = f.RoomID AND f.RoomID like '_03'";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p> Pool room " . $row['RoomID'] . " reserved for " . $row['Duration'] . " hours on " . $row['Date'] . "</p>";
    }
    return $row;
}
// Get currently booked sauna room info
function getSaunaBookings($conn)
{
    $sql = "SELECT distinct b.FacilityRoomID as RoomID, b.Duration as Duration, b.BookingDATE as Date FROM book b, facilities f WHERE b.FacilityRoomID = f.RoomID AND f.RoomID like '_02'";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p> Sauna room " . $row['RoomID'] . " reserved for " . $row['Duration'] . " hours on " . $row['Date'] . "</p>";
    }
    return $row;
}
// Get currently booked gym room info
function getGymBookings($conn)
{
    $sql = "SELECT distinct b.FacilityRoomID as RoomID, b.Duration as Duration, b.BookingDATE as Date FROM book b, facilities f WHERE b.FacilityRoomID = f.RoomID AND f.RoomID like '_04'";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p> Gym room " . $row['RoomID'] . " reserved for " . $row['Duration'] . " hours on " . $row['Date'] . "</p>";
    }
    return $row;
}
// Get currently available laundry room info
function getAvailableLaundryBookings($conn)
{
    $sql = "SELECT f.RoomID FROM facilities f WHERE f.RoomID like '_01'AND f.RoomID NOT IN (SELECT DISTINCT FacilityRoomID from book)";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p> Laundry room " . $row['RoomID'] . " available </p>";
    }
    return $row;
}
// Get currently available sauna room info
function getAvailableSaunaBookings($conn)
{
    $sql = "SELECT f.RoomID FROM facilities f WHERE f.RoomID like '_02'AND f.RoomID NOT IN (SELECT DISTINCT FacilityRoomID from book)";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p> Sauna room " . $row['RoomID'] . " available </p>";
    }
    return $row;
}
// Get currently available pool room info
function getAvailablePoolBookings($conn)
{
    $sql = "SELECT f.RoomID FROM facilities f WHERE f.RoomID like '_03'AND f.RoomID NOT IN (SELECT DISTINCT FacilityRoomID from book)";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p> Pool room " . $row['RoomID'] . " available </p>";
    }
    return $row;
}
// Get currently available gym room info
function getAvailableGymBookings($conn)
{
    $sql = "SELECT f.RoomID FROM facilities f WHERE f.RoomID like '_04'AND f.RoomID NOT IN (SELECT DISTINCT FacilityRoomID from book)";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p> Gym room " . $row['RoomID'] . " available </p>";
    }
    return $row;
}
// Get current user's laundry room booking info
function getUserLaundryBookings($conn, $user)
{
    $sql = "SELECT distinct b.FacilityRoomID as RoomID, b.Duration as Duration, b.BookingDATE as Date, b.TenantSIN as TenantSIN FROM book b, tenant_account ta, tenant t WHERE ta.AccountUsername = '$user' AND ta.FirstName = t.FirstName AND ta.LastName = t.LastName AND t.SIN = b.TenantSIN AND b.FacilityRoomID like '_01'";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p><a href='../controllers/deleteBooking.inc.php?id=" . $row['RoomID'] . "'> You have reserved: Laundry room " . $row['RoomID'] . " for " . $row['Duration'] . " hours on " . $row['Date'] . "</a></p>";
    }
    return $row;
}
// Get current user's sauna room booking info
function getUserSaunaBookings($conn, $user)
{
    $sql = "SELECT distinct b.FacilityRoomID as RoomID, b.Duration as Duration, b.BookingDATE as Date, b.TenantSIN as TenantSIN FROM book b, tenant_account ta, tenant t WHERE ta.AccountUsername = '$user' AND ta.FirstName = t.FirstName AND ta.LastName = t.LastName AND t.SIN = b.TenantSIN AND b.FacilityRoomID like '_02'";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p> <a href='../controllers/deleteBooking.inc.php?id=" . $row['RoomID'] . "'>You have reserved: Sauna room " . $row['RoomID'] . " for " . $row['Duration'] . " hours on " . $row['Date'] . "</a></p>";
    }
    return $row;
}
// Get current user's pool room booking info
function getUserPoolBookings($conn, $user)
{
    $sql = "SELECT distinct b.FacilityRoomID as RoomID, b.Duration as Duration, b.BookingDATE as Date, b.TenantSIN as TenantSIN FROM book b, tenant_account ta, tenant t WHERE ta.AccountUsername = '$user' AND ta.FirstName = t.FirstName AND ta.LastName = t.LastName AND t.SIN = b.TenantSIN AND b.FacilityRoomID like '_03'";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p><a href='../controllers/deleteBooking.inc.php?id=" . $row['RoomID'] . "'> You have reserved: Pool room " . $row['RoomID'] . " for " . $row['Duration'] . " hours on " . $row['Date'] . "</a></p>";
    }
    return $row;
}
// Get current user's gym room booking info
function getUserGymBookings($conn, $user)
{
    $sql = "SELECT distinct b.FacilityRoomID as RoomID, b.Duration as Duration, b.BookingDATE as Date, b.TenantSIN as TenantSIN FROM book b, tenant_account ta, tenant t WHERE ta.AccountUsername = '$user' AND ta.FirstName = t.FirstName AND ta.LastName = t.LastName AND t.SIN = b.TenantSIN AND b.FacilityRoomID like '_04'";
    $result = $conn->query($sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<p><a href='../controllers/deleteBooking.inc.php?id=" . $row['RoomID'] . "'> You have reserved: Gym room " . $row['RoomID'] . " for " . $row['Duration'] . " hours on " . $row['Date'] . "</a></p>";
    }
    return $row;
}

// Inserts a new booking row into database
function createBooking($conn, $roomID, $duration, $date, $currUsername)
{
    $tenantSIN = getTenantSIN($conn, $currUsername);
    $sql = "INSERT INTO book VALUES ('$tenantSIN', '$roomID', '1001', '$duration', '$date')";
    $conn->query($sql);
    header("location: ../views/facilities.php");
    exit();
}

// Retrieves post information to handle creating a booking
function facilitiesHandler()
{
    $currUsername =  $_SESSION['username'];
    $roomID = $_POST['roomID'];
    $duration = $_POST['duration'];
    $date = $_POST['date'];

    createBooking($GLOBALS['conn'], $roomID, $duration, $date, $currUsername);
}
