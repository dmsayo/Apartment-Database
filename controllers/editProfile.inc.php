<?php
require_once 'connection.inc.php';
require_once 'functions.inc.php';
require_once 'navbar.inc.php';

/* Retrieves the email with query*/
function getEmail($conn, $username)
{
    $sql_get_email = "SELECT Email FROM account WHERE Username ='$username'";
    $result_email = $conn->query($sql_get_email);
    $row_email = mysqli_fetch_assoc($result_email);
    return $row_email['Email'];
}

/* Retrieves the current user's first name */
function getFirstName($conn, $username, $usertype)
{
    if ($usertype == 'tenant') {
        $sql_get_fn_tenant = "SELECT t.FirstName FROM tenant_account t, account a WHERE t.AccountUsername = a.Username AND t.AccountUsername = '$username'";
        $result_tenant_fname = $conn->query($sql_get_fn_tenant);
        $row_tenant_fname = mysqli_fetch_assoc($result_tenant_fname);
        return $row_tenant_fname['FirstName'];
    } else if ($usertype == 'landlord') {
        $sql_get_fn_landlord = "SELECT l.FirstName FROM landlord_account l, account a WHERE l.AccountUsername = a.Username AND l.AccountUsername ='$username'";
        $result_landlord_fname = $conn->query($sql_get_fn_landlord);
        $row_landlord_fname = mysqli_fetch_assoc($result_landlord_fname);
        return $row_landlord_fname['FirstName'];
    } else { /* guest */
        return "Guest";
    }
}

/* Retrieves the current user's last name */
function getLastname($conn, $username, $usertype)
{
    if ($usertype == 'tenant') {
        $sql_get_ln_tenant = "SELECT t.LastName FROM tenant_account t, account a WHERE t.AccountUsername = a.Username AND t.AccountUsername = '$username'";
        $result_tenant_lname = $conn->query($sql_get_ln_tenant);
        $row_tenant_lname = mysqli_fetch_assoc($result_tenant_lname);
        return $row_tenant_lname['LastName'];
    } else if ($usertype == 'landlord') {
        $sql_get_ln_landlord = "SELECT l.LastName FROM landlord_account l, account a WHERE l.AccountUsername = a.Username AND l.AccountUsername ='$username'";
        $result_landlord_lname = $conn->query($sql_get_ln_landlord);
        $row_landlord_lname = mysqli_fetch_assoc($result_landlord_lname);
        return $row_landlord_lname['LastName'];
    } else { /* guest */
        return "Guest";
    }
}

/* Retrieves the current user's telephone number*/
// TODO: change the schema in the sql file to have the same format column name for both
function getTelephoneNum($conn, $username, $usertype)
{
    if ($usertype == 'tenant') {
        $sql_get_tnum_tenant = "SELECT t.TelephoneNum FROM tenant_account t, account a WHERE t.AccountUsername = a.Username AND t.AccountUsername = '$username'";
        $result_tenant_tnum = $conn->query($sql_get_tnum_tenant);
        $row_tenant_tnum = mysqli_fetch_assoc($result_tenant_tnum);
        return $row_tenant_tnum['TelephoneNum'];
    } else if ($usertype == 'landlord') {
        $sql_get_tnum_landlord = "SELECT l.TelephoneNumber FROM landlord_account l, account a WHERE l.AccountUsername = a.Username AND l.AccountUsername ='$username'";
        $result_landlord_tnum = $conn->query($sql_get_tnum_landlord);
        $row_landlord_tnum = mysqli_fetch_assoc($result_landlord_tnum);
        return $row_landlord_tnum['TelephoneNumber'];
    } else { /* guest */
        return "Guest";
    }
}

/* Retrieves the current user's building's current landlord */
// TODO: add case where a landlord account is logging in
function getLandlordName($conn, $username)
{
    $sql_get_lllname = "SELECT l.LastName FROM landlord l, tenant_account t, apartmentbuilding ab, apartmentspace a WHERE t.AccountUsername = '$username' AND t.ApartmentRoomID = a.RoomID AND a.BuildingID = ab.BuildingID AND ab.LandlordSIN =l.SIN";
    $sql_get_llfname = "SELECT l.FirstName FROM landlord l, tenant_account t, apartmentbuilding ab, apartmentspace a WHERE t.AccountUsername = '$username' AND t.ApartmentRoomID = a.RoomID AND a.BuildingID = ab.BuildingID AND ab.LandlordSIN =l.SIN";
    $result_lllname = $conn->query($sql_get_lllname);
    $result_llfname = $conn->query($sql_get_llfname);
    $row_lllname = mysqli_fetch_assoc($result_lllname);
    $row_llfname = mysqli_fetch_assoc($result_llfname);
    return $row_llfname['FirstName'] . " " . $row_lllname['LastName'];
}


/* Retrieves the number of incidents the current resident has been involved in */
function getNumIncidents($conn, $username)
{
    $sql_get_numincidents = "SELECT NumOfIncidents FROM tenant_account a WHERE a.AccountUsername = '$username'";
    $result_numincidents = $conn->query($sql_get_numincidents);
    $row_numincidents = mysqli_fetch_assoc($result_numincidents);
    return $row_numincidents['NumOfIncidents'];
}

/* Retrieves the current floor number that the user is living in*/
function getFloorNum($conn, $username)
{
    $sql_get_floornum = "SELECT FloorNo FROM apartmentspace asp, tenant_account t WHERE t.AccountUsername = '$username' AND t.ApartmentRoomID = asp.RoomID";
    $result_floornum = $conn->query($sql_get_floornum);
    $row_floornum = mysqli_fetch_assoc($result_floornum);
    return $row_floornum['FloorNo'];
}

/* Retrieves the tenant's contract ID */
function getContractID($conn, $username)
{
    $sql_get_cid = "SELECT ContractID FROM tenant_account a WHERE a.AccountUsername = '$username'";
    $result_cid = $conn->query($sql_get_cid);
    $row_cid = mysqli_fetch_assoc($result_cid);
    return $row_cid['ContractID'];
}

/* Retrieves the current user's password */
function getPassword($conn, $username)
{
    $sql = "SELECT Password FROM account WHERE Username = '$username'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['Password'];
}


/* Checks if the current password has been changed */
function changedPassword($currPass, $newPass)
{
    return $currPass !== $newPass;
}

/* Updates database to contain changed profile values */
function editProfile($conn, $newEmail, $newTele, $newUsername, $newPass, $currUsername, $userType)
{

    $sql_updateAccountUsername = "UPDATE account SET Username = '$newUsername' WHERE Username = '$currUsername' ";
    $sql_updateAccountEmail = "UPDATE account SET Email = '$newEmail' WHERE Username = '$currUsername' ";
    $sql_updatePassword = "UPDATE account set Password = '$newPass' WHERE Username = '$currUsername'";
    if ($userType === 'tenant') {
        $sql_updateTenantAccountUsername = "UPDATE tenant_account SET AccountUsername = '$newUsername'WHERE AccountUsername = '$currUsername' ";
        $sql_updateTenantAccountEmail = "UPDATE tenant_account SET Email = '$newEmail' WHERE AccountUsername = '$currUsername' ";
        $sql_updateTenantAccountTele = "UPDATE tenant_account SET TelephoneNum = '$newTele'WHERE AccountUsername = '$currUsername' ";

        $conn->query($sql_updateAccountEmail);
        $conn->query($sql_updatePassword);
        $conn->query($sql_updateTenantAccountEmail);
        $conn->query($sql_updateTenantAccountTele);
        $conn->query($sql_updateAccountUsername);
        $conn->query($sql_updateTenantAccountUsername);
    } else {
        $sql_updateLandlordAccountUsername = "UPDATE landlord_account SET AccountUsername = '$newUsername'WHERE AccountUsername = '$currUsername' ";
        $sql_updateLandlordAccountEmail = "UPDATE landlord_account SET Email = '$newEmail' WHERE AccountUsername = '$currUsername' ";
        $sql_updateLandlordAccountTele = "UPDATE landlord_account SET TelephoneNumber = '$newTele'WHERE AccountUsername = '$currUsername' ";

        $conn->query($sql_updateAccountEmail);
        $conn->query($sql_updatePassword);
        $conn->query($sql_updateLandlordAccountEmail);
        $conn->query($sql_updateLandlordAccountTele);
        $conn->query($sql_updateAccountUsername);
        $conn->query($sql_updateLandlordAccountUsername);
    }


    $_SESSION['username'] = $newUsername;
    header("location: ../views/profile.php?error=none");
    exit();
}


/* Checks to see if fields are valid then updates database to contain new values */
function  editProfileHandler()
{
    $currUsername =  $_SESSION['username'];
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];
    $newTele = $_POST['newTelephone'];
    $newPass = $_POST['newPassword'];
    $newPassRpt = $_POST['newPasswordRpt'];
    $userType = checkUserType($GLOBALS['conn'], $_SESSION['username']);

    if (changedPassword(getPassword($GLOBALS['conn'], $_SESSION['username']), $newPass) !== false) {
        if (passwordDoNotMatch($newPass, $newPassRpt) !== false) {
            header("location: ../views/profile.php?error=passwordnomatch");
            exit();
        }
    }
    if ($currUsername !== $newUsername) {
        if (usernameExists($GLOBALS['conn'], $newUsername) !== false) {
            header("location: ../views/profile.php?error=usernametaken");
            exit();
        }
    }
     if (invalidEmail($newEmail) !== false) {
        header("location: ../views/profile.php?error=invalidemail");
        exit();
    }
    editProfile($GLOBALS['conn'], $newEmail, $newTele, $newUsername, $newPass, $currUsername, $userType);
}
