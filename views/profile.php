<?php
include '../views/templates/header.php';
include '../views/templates/navbar.php';
include '../controllers/landlord.inc.php';
include '../controllers/tenant.inc.php';
include '../controllers/editProfile.inc.php';

connectToDB();
$userType = checkUserType($GLOBALS['conn'], $_SESSION['username']);
$currUsername = $_SESSION['username'];
$userPassword = getPassword($GLOBALS['conn'], $_SESSION['username']);
$tenantInfo = $landlordInfo = $tenantSIN = $landlordSIN = null;
$tenantFnLn = $landlordFnLn = null;
$tenantApartmentInfo = $fullAddress = null;
$totalNumTenants = $subtotalOfAllRents = null;
if ($userType === "tenant") {
    $tenantSIN = getTenantSIN($GLOBALS['conn'], $_SESSION['username']);
    $tenantInfo = getTenantInfo($GLOBALS['conn'], $_SESSION['username']);
    $tenantFnLn = $tenantInfo['FirstName'] . " " . $tenantInfo['LastName'];
    $tenantApartmentInfo = getTenantApartmentInfo($GLOBALS['conn'], $_SESSION['username']);
    $fullAddress = getFullAddress($GLOBALS['conn'], $tenantApartmentInfo['Address']);
} else if ($userType === "landlord") {
    $landlordSIN = getLandlordSIN($GLOBALS['conn'], $_SESSION['username']);
    $landlordInfo = getLandlordInfo($GLOBALS['conn'], $_SESSION['username']);
    $landlordFnLn = $landlordInfo['FirstName'] . " " . $landlordInfo['LastName'];
    $fullAddress = getFullAddress($GLOBALS['conn'], $landlordInfo['Address']);
    $totalNumTenants = getNumberOfTenantsForLandlord($GLOBALS['conn'], $landlordSIN);
    $subtotalOfAllRents = getSubtotalOfAllRents($GLOBALS['conn'], $landlordSIN);
}
closeConnection();
?>
<main class="container pb-3">
    <div class="d-flex p-3 my-3 text-white bg-secondary rounded shadow-sm">
        <div class="lh-1">
            <h4 class="mb-0 text-white lh-1">Your Profile</h4>
        </div>
    </div>
    <div class="my-3 p-3 bg-body rounded shadow-sm" style="text-align: initial">
        <div>
            <h5>
                <?php echo ($userType === "tenant" ? $tenantFnLn : $landlordFnLn) ?>
            </h5>
        </div>
        <hr />
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "usernametaken") {
                echo "<p> This Username Has Been Taken </p><hr/>";
            } else if ($_GET["error"] == "passwordnomatch") {
                echo "<p> The Repeated Password Doesn't Match </p><hr/>";
            } else if ($_GET["error"] == "none") {
                echo "<p> Successfully Changed Profile </p><hr/>";
            }
            else if ($_GET["error"] == "invalidemail") {
                echo "<p> Email Format is Invalid </p><hr/>";
            }
        }
        ?>
        <form method="POST" action="../controllers/formHandler.inc.php" id="editProfileForm">
            <table class="table profileTables">
                <tbody>
                    <tr>
                        <th class="col-3" scope="row">Username</th>
                        <td><input type="text" name="newUsername" class="form-control" id="floatingInput" placeholder="New Username" value="<?php echo $currUsername; ?>" required></td>
                    </tr>
                    <tr>
                        <th class="col-3" scope="row">Email</th>
                        <td><input type="text" name="newEmail" class="form-control" id="floatingInput" placeholder="New Email" value="<?php echo ($userType === "tenant") ? $tenantInfo['Email'] : $landlordInfo['Email']; ?>" required></td>
                    </tr>
                    <tr>
                        <th class="col-3" scope="row">Telephone</th>
                        <td><input type="text" name="newTelephone" class="form-control" id="floatingInput" placeholder="New Telephone" value="<?php echo ($userType === "tenant") ? $tenantInfo['TelephoneNum'] : $landlordInfo['TelephoneNumber']; ?>" required></td>
                    </tr>
                    <tr>
                        <th class="col-3" scope="row">Password</th>
                        <td><input type="password" name="newPassword" class="form-control" id="floatingPass" placeholder="New Password" value="<?php echo $userPassword; ?>" required></td>
                    </tr>
                    <tr>
                        <th class="col-3" scope="row">Repeat Password</th>
                        <td><input type="password" name="newPasswordRpt" class="form-control" id="floatingPassRpt" placeholder="Repeat New Password If Changed"></td>
                    </tr>
                    <tr class="pb-5">
                        <th class="col-3" scope="row">Date of Birth</th>
                        <td class="col-9"><?php echo ($userType === "tenant") ? $tenantInfo['DateOfBirth'] : $landlordInfo['DateOfBirth']; ?></td>
                    </tr>
                    <tr>
                        <th class="col-3" scope="row">Social Insurance Number</th>
                        <td class="col-9"><?php echo ($userType === "tenant") ? $tenantSIN : $landlordSIN; ?></td>
                    </tr>
                    <?php
                    if ($userType === "landlord") {
                        echo "<tr>
                                    <th class='col-3' scope='row'>Building Address</th>
                                    <td class='col-9'>
                                        {$fullAddress['Address']}, {$fullAddress['City']}, {$fullAddress['Province']} {$fullAddress['Country']}
                                    </td>
                                </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            if ($userType === "tenant") {
                echo "<div class='pt-3'>
                        <h5>Apartment Information</h5>
                        </div>
                        <hr />
                        <table class='table profileTables'>
                            <tbody>
                                <tr>
                                    <th class='col-3' scope='row'>Landlord</th>
                                    <td class='col-9'>{$tenantApartmentInfo['LandlordFirstName']} {$tenantApartmentInfo['LandlordLastName']}</td>
                                </tr>
                                <tr>
                                    <th class='col-3' scope='row'>Contract ID</th>
                                    <td class='col-9'>{$tenantApartmentInfo['ContractID']}</td>
                                </tr>
                                <tr>
                                    <th class='col-3' scope='row'>Building Address</th>
                                    <td class='col-9'>{$fullAddress['Address']}, {$fullAddress['City']}, {$fullAddress['Province']} {$fullAddress['Country']}</td>
                                </tr>
                                <tr>
                                    <th class='col-3' scope='row'>Unit</th>
                                    <td class='col-9'>{$tenantApartmentInfo['RoomID']}</td>
                                </tr>
                                <tr>
                                    <th class='col-3' scope='row'>Floor Number</th>
                                    <td class='col-9'>{$tenantApartmentInfo['FloorNo']}</td>
                                </tr>
                                <tr>
                                    <th class='col-3' scope='row'>Parking Lot Number</th>
                                    <td class='col-9'>{$tenantApartmentInfo['LotNumber']}</td>
                                </tr>
                                <tr>
                                    <th class='col-3' scope='row'>Number of Incidents</th>
                                    <td class='col-9'>{$tenantApartmentInfo['NumOfIncidents']}</td>
                                </tr>
                            </tbody>
                        </table>";
            }
            ?>
            <button class="register-btn w-100 btn btn-lg btn-success" type="submit" id="editProfileSubmit" name="editProfileSubmit" value="Submit" form="editProfileForm">Submit Changes</button>
        </form>
    </div>
</main>
<link href="../css/application.css" rel="stylesheet">
<?php include('../views/templates/footer.php'); ?>