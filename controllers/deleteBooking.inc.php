<?php
require_once 'connection.inc.php';
require_once 'tenant.inc.php';
require_once 'navbar.inc.php';

// Script that run to delete a row from clicking on a link in facilities page
connectToDB();
$conn = $GLOBALS['conn'];
$roomID = $_GET['id'];
$tenantSIN = getTenantSIN($conn, $_SESSION['username']);
$sql = "DELETE FROM book WHERE FacilityRoomID = '$roomID'";
if (!$conn->query($sql)) {
    header("location: ../views/facilities.php?error=baddelete");
    exit();
} else {
    header("location: ../views/facilities.php?error=none");
    exit();
}
closeConnection();