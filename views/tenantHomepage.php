<?php
include '../views/templates/header.php';
include '../views/templates/navbar.php';
include '../controllers/editProfile.inc.php';
include '../controllers/landlord.inc.php';
include '../controllers/tenant.inc.php';
include '../controllers/contract.inc.php';

connectToDB();
$userType = checkUserType($GLOBALS['conn'], $_SESSION['username']);
$tenantInfo = getTenantInfo($GLOBALS['conn'], $_SESSION['username']);
$tenantApartmentInfo = getTenantApartmentInfo($GLOBALS['conn'], $_SESSION['username']);
$tenantContract = getContractAttributes($GLOBALS['conn'], $_SESSION['username']);
$tenantUtilities = [];
$utilitiesTotal = 0;
if (getUtilityID($GLOBALS['conn'], $_SESSION['username'])) {
    $tenantUtilities = [
        'gas' => getGasUsage($GLOBALS['conn'], $_SESSION['username']),
        'internet' => getInternetUsage($GLOBALS['conn'], $_SESSION['username']),
        'electricity' => getElectricityUsage($GLOBALS['conn'], $_SESSION['username']),
        'hydro' => getHydroUsage($GLOBALS['conn'], $_SESSION['username'])
    ];
    $utilitiesTotal = $tenantUtilities['gas'] + $tenantUtilities['internet'] + $tenantUtilities['electricity'] + $tenantUtilities['hydro'];
}
$totalWithRent = $utilitiesTotal + $tenantContract['RentalFee'];
/* personal info and apartment info */
$tenantSIN = getTenantSIN($GLOBALS['conn'], $_SESSION['username']);
$tenantInfo = getTenantInfo($GLOBALS['conn'], $_SESSION['username']);
$tenantFnLn = $tenantInfo['FirstName'] . " " . $tenantInfo['LastName'];
$tenantApartmentInfo = getTenantApartmentInfo($GLOBALS['conn'], $_SESSION['username']);
$fullAddress = getFullAddress($GLOBALS['conn'], $tenantApartmentInfo['Address']);
closeConnection();
?>
<script>
    $(document).ready(function() {
        $("button[name$='displayUtilitiesButton']").click(function() {
            $('#personalInformationSection').css('display', 'none');
            $('#apartmentInformationSection').css('display', 'none');
            $('#utilitiesSection').css('display', 'block');
        });
        $("button[name$='displayPersonalInformation']").click(function() {
            $('#utilitiesSection').css('display', 'none');
            $('#apartmentInformationSection').css('display', 'none');
            $('#personalInformationSection').css('display', 'block');
        });
        $("button[name$='displayApartmentInformation']").click(function() {
            $('#utilitiesSection').css('display', 'none');
            $('#personalInformationSection').css('display', 'none');
            $('#apartmentInformationSection').css('display', 'block');
        });
        $("button[name$='optOutOfUtilities']").click(function() {
            $.ajax({
                type: 'POST',
                url: '../controllers/deleteUtilities.inc.php',
                success: function() {}
            });
        });
    });
</script>
<main class="container pb-3">
    <div class="d-flex p-3 my-3 text-white bg-secondary rounded shadow-sm">
        <div class="lh-1">
            <h4 class="mb-0 text-white lh-1">Welcome, <?php echo $tenantInfo['FirstName']; ?>.</h4>
        </div>
    </div>
    <div style="display: flex; justify-content: space-around;">
        <button class="btn btn-lg btn-success" type="submit" name="displayUtilitiesButton">Your Utilities</button>
        <button class="btn btn-lg btn-info" type="submit" name="displayPersonalInformation">Personal Information</button>
        <button class="btn btn-lg btn-warning" type="submit" name="displayApartmentInformation">Apartment Information</button>
    </div>
    <div id="utilitiesSection" class="my-3 p-3 bg-body rounded shadow-sm" style="display: block; text-align: initial">
        <div class="lh-1" style="text-align: center">
            <h4 class="mb-0 lh-1">Your Utility Expenses</h4>
        </div>
        <hr/>
        <div class="lh-1 pb-2" style="text-align: center">
            <h6 class="mb-0 lh-1">Contract ID: <?php echo $tenantApartmentInfo['ContractID']; ?> </h6>
        </div>
        <table class="table tenantUtilityExpensesTable">
            <tbody>
            <tr>
                <th scope="col">Utility Type</th>
                <th scope="col">Consumption Amount</th>
            </tr>
            <tr>
                <th class="col-4" scope="row">Gas</th>
                <td class="col-4">
                    <?php
                        if ($tenantUtilities) {
                            echo $tenantUtilities['gas'];
                        } else {
                            echo "n/a";
                        }
                    ?>
                </td>
            </tr>
            <tr class="pb-5">
                <th class="col-4" scope="row">Internet</th>
                <td class="col-4">
                    <?php
                        if ($tenantUtilities) {
                            echo $tenantUtilities['internet'];
                        } else {
                            echo "n/a";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th class="col-4" scope="row">Electricity</th>
                <td class="col-4">
                    <?php
                        if ($tenantUtilities) {
                            echo $tenantUtilities['electricity'];
                        } else {
                            echo "n/a";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th class="col-4" scope="row">Hydro</th>
                <td class="col-4">
                    <?php
                        if ($tenantUtilities) {
                            echo $tenantUtilities['hydro'];
                        } else {
                            echo "n/a";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th class="col-4 table-secondary" scope="row">Utilities Total:</th>
                <td class="col-4 table-secondary"><strong>$<?php echo $utilitiesTotal; ?></strong></td>
            </tr>
            <tr>
                <th class="col-4 table-warning" scope="row">Total w/ Rental Fee included:</th>
                <td class="col-4 table-warning"><strong>$<?php echo $totalWithRent; ?></strong></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div id="personalInformationSection" class="my-3 p-3 bg-body rounded shadow-sm" style="display: none; text-align: initial">
        <div class="lh-1" style="text-align: center">
            <h4 class="mb-0 lh-1">Personal Information</h4>
        </div>
        <hr/>
        <table class="table tenantHomepageTables">
            <tbody>
            <tr>
                <th class="col-4" scope="row">Username</th>
                <td class="col-4"><?php echo "{$_SESSION['username']}"; ?></td>
            </tr>
            <tr>
                <th class="col-4" scope="row">Email</th>
                <td class="col-4"><?php echo "{$tenantInfo['Email']}"; ?></td>
            </tr>
            <tr>
                <th class="col-4" scope="row">Telephone</th>
                <td class="col-4"><?php echo "{$tenantInfo['TelephoneNum']}"; ?></td>
            </tr>
            <tr>
                <th class="col-4" scope="row">Date of Birth</th>
                <td class="col-4"><?php echo "{$tenantInfo['DateOfBirth']}"; ?></td>
            </tr>
            <tr>
                <th class="col-4" scope="row">Social Insurance Number</th>
                <td class="col-4"><?php echo "{$tenantInfo['SIN']}"; ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div id="apartmentInformationSection" class="my-3 p-3 bg-body rounded shadow-sm" style="display: none; text-align: initial">
        <div class="lh-1" style="text-align: center">
            <h4 class="mb-0 lh-1">Apartment Information</h4>
        </div>
        <hr/>
        <table class='table tenantHomepageTables'>
            <tbody>
            <tr>
                <th class='col-4' scope='row'>Landlord</th>
                <td class='col-4'><?php echo "{$tenantApartmentInfo['LandlordFirstName']} {$tenantApartmentInfo['LandlordLastName']}"; ?></td>
            </tr>
            <tr>
                <th class='col-4' scope='row'>Contract ID</th>
                <td class='col-4'><?php echo "{$tenantApartmentInfo['ContractID']}" ?></td>
            </tr>
            <tr>
                <th class='col-4' scope='row'>Building Address</th>
                <td class='col-4'><?php echo "{$fullAddress['Address']}, {$fullAddress['City']}, {$fullAddress['Province']} {$fullAddress['Country']}" ?></td>
            </tr>
            <tr>
                <th class='col-4' scope='row'>Unit</th>
                <td class='col-4'><?php echo "{$tenantApartmentInfo['RoomID']}" ?></td>
            </tr>
            <tr>
                <th class='col-4' scope='row'>Floor Number</th>
                <td class='col-4'><?php echo "{$tenantApartmentInfo['FloorNo']}" ?></td>
            </tr>
            <tr>
                <th class='col-4' scope='row'>Parking Lot Number</th>
                <td class='col-4'><?php echo "{$tenantApartmentInfo['LotNumber']}" ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <?php
        if ($tenantUtilities) {
            echo "
                <div style='display:flex;'>
                    <div style='padding-top:10px;'>
                        <h6 style='padding-right:10px;'>Going on vacation?</h6>
                    </div>
                    <form method='POST' action='../views/tenantHomepage.php' id='deleteUtilities'>
                        <button class='pl-2 btn btn-md btn-danger' type='submit' name='optOutOfUtilities'>Cancel All Utility Charges</button>
                    </form>
                </div>        
            ";
        }
    ?>
</main>
<link href="../css/application.css" rel="stylesheet">
<?php include('../views/templates/footer.php'); ?>
