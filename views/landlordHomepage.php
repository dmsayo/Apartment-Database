<?php
    include '../views/templates/header.php';
    include '../views/templates/navbar.php';
    include '../controllers/editProfile.inc.php';
    include '../controllers/landlord.inc.php';

    connectToDB();
    $userType = checkUserType($GLOBALS['conn'], $_SESSION['username']);
    $landlordInfo = getLandlordInfo($GLOBALS['conn'], $_SESSION['username']);
    $landlordSIN = getLandlordSIN($GLOBALS['conn'], $_SESSION['username']);
    $allTenantsRentStatus = getAllTenantsRentStatus($GLOBALS['conn'], $landlordSIN);
    $allTenants = getAllTenants($GLOBALS['conn'], $landlordSIN);
    $totalNumTenants = getNumberOfTenantsForLandlord($GLOBALS['conn'], $landlordSIN);
    $subtotalOfAllRents = getSubtotalOfAllRents($GLOBALS['conn'], $landlordSIN);
    $averageRentalFee = getAverageRentalFee($GLOBALS['conn'], $landlordSIN);
    $tenantBelowAverage = getTenantBelowAverage($GLOBALS['conn'], $landlordSIN);
    $tenantAboveAverage = getTenantAboveAverage($GLOBALS['conn'], $landlordSIN);
    closeConnection();
?>
<script>
    /*
     * Event handler to run SQL query on button click and display results.
     * SQL query run from function 'getTenantByLastName' in landlord.inc.php
     */
    $(document).ready(function() {
        $("#searchTenantByLastNameSubmit").click(function() {
            $.ajax({
                type: 'POST',
                url: '../controllers/searchTenant.inc.php',
                data: {
                    searchInput: $('#searchTenantByLastNameText').val()
                },
                success: function(result) {
                    let tenantResult = eval(result);
                    if (tenantResult) {
                        $('#noSearchResults').css('display', 'none'); // hide 'No results given' div
                        // populate <td> with query results
                        $('#tenantLastNameSearchResults').css('display', 'block');
                        $('#searchResultName').html(tenantResult[0] + ' ' + tenantResult[1]);
                        $('#searchResultUnit').html(tenantResult[2]);
                        $('#searchResultTelephone').html(tenantResult[3]);
                        $('#searchResultEmail').html(tenantResult[4]);
                        $('#searchResultContractID').html(tenantResult[5]);
                        $('#searchResultNumOfIncidents').html(tenantResult[6]);
                    } else { // no match on user input search
                        $('#tenantLastNameSearchResults').css('display', 'none');
                        $('#noSearchResults').css('display', 'block');
                    }
                }
            });
        });
    });
</script>
<main class="container pb-3">
    <div class="d-flex p-3 my-3 text-white bg-secondary rounded shadow-sm">
        <div class="lh-1">
            <h4 class="mb-0 text-white lh-1">Hi, <?php echo $landlordInfo['FirstName']; ?>.</h4>
        </div>
    </div>
    <div class="my-3 p-3 bg-primary text-white rounded shadow-sm" style="text-align: initial">
        Search Tenants
        <div>
            <input type="text"
                   name="searchTenants"
                   id="searchTenantByLastNameText"
                   placeholder="Search by last name"
                   value="" required>
            <button class="register-btn btn btn-secondary"
                    type="submit"
                    id="searchTenantByLastNameSubmit"
                    name="searchTenantByLastNameSubmit"
                    value=""
                    form="searchTenantByLastNameForm">Search</button>
        </div>
    </div>
    <div id="noSearchResults" class="searchResultsHeader" style="display: none;">
        <h4>No results given for search.</h4>
    </div>
    <div id="tenantLastNameSearchResults" style="display: none;">
        <div class="searchResultsHeader">
            <h4>Search Results</h4>
        </div>
        <table class="table table-info table-striped">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Unit</th>
                <th scope="col">Telephone</th>
                <th scope="col">Email</th>
                <th scope="col">Contract ID</th>
                <th scope="col">No. of Incidents</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td id="searchResultName"></td>
                <td id="searchResultUnit"></td>
                <td id="searchResultTelephone"></td>
                <td id="searchResultEmail"></td>
                <td id="searchResultContractID"></td>
                <td id="searchResultNumOfIncidents"></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action list-group-item-primary" id="list-numOfTenants-list" data-bs-toggle="list" href="#list-numOfTenants" role="tab" aria-controls="list-numOfTenants">The Number of Your Tenant <i class="fas fa-bed fa-lg"></i></a>
                <a class="list-group-item list-group-item-action list-group-item-secondary" id="list-totalRents-list" data-bs-toggle="list" href="#list-totalRents" role="tab" aria-controls="list-totalRents">Your Subtotal of All Rents <i class="fas fa-search-dollar fa-lg"></i></a>
                <a class="list-group-item list-group-item-action list-group-item-warning" id="list-averageRentalFee-list" data-bs-toggle="list" href="#list-averageRentalFee" role="tab" aria-controls="list-averageRentalFee">Average Rental Fee <i class="fas fa-comment-dollar"></i></a>
                <a class="list-group-item list-group-item-action list-group-item-danger" id="list-tenantsBelowAverage-list" data-bs-toggle="list" href="#list-tenantsBelowAverage" role="tab" aria-controls="list-tenantsBelowAverage">Tenants Pay Below Average <i class="fas fa-arrow-circle-down"></i></a>
                <a class="list-group-item list-group-item-action list-group-item-info" id="list-tenantsAboveAverage-list" data-bs-toggle="list" href="#list-tenantsAboveAverage" role="tab" aria-controls="list-tenantsAboveAverage">Tenants Pay Above Average <i class="fas fa-arrow-circle-up"></i></i></a>
            </div>
        </div>
        <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade textAlign  list-group-item-primary" id="list-numOfTenants"  role="tabpanel" aria-labelledby="list-numOfTenants-list"><?php echo "You have $totalNumTenants tenants" ?></div>
                <div class="tab-pane fade list-group-item-secondary" id="list-totalRents" role="tabpanel" aria-labelledby="list-totalRents-list"><?php echo"Your Total Monthly Rent Received : $$subtotalOfAllRents" ?></div>
                <div class="tab-pane fade list-group-item-warning" id="list-averageRentalFee" role="tabpanel" aria-labelledby="list-averageRentalFee-list"><?php echo"The Average Rental Fee : $$averageRentalFee" ?></div>
                <div class="tab-pane fade" id="list-tenantsBelowAverage" role="tabpanel" aria-labelledby="list-tenantsBelowAverage-list">
                    <table class="table table-danger table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Monthly Rent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($tenantBelowAverage as $tenantBelow) {
                                    echo "<tr>
                                                <td>{$tenantBelow['FirstName']} {$tenantBelow['LastName']}</td>
                                                <td>\${$tenantBelow['RentalFee']}</td>
                                         </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="list-tenantsAboveAverage" role="tabpanel" aria-labelledby="list-tenantsAboveAverage-list">
                    <table class="table table-info table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Monthly Rent</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($tenantAboveAverage as $tenantAbove) {
                                    echo "<tr>
                                              <td>{$tenantAbove['FirstName']} {$tenantAbove['LastName']}</td>
                                              <td>\${$tenantAbove['RentalFee']}</td>
                                          </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="my-3 p-3 bg-success text-white rounded shadow-sm" style="text-align: initial">
        Tenants Rent Status
    </div>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Unit</th>
                <th scope="col">Floor Number</th>
                <th scope="col">Balance Due</th>
                <th scope="col">Notify Tenant</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($allTenantsRentStatus as $tenantRentStatus) {
                    echo "<tr>
                                <td>{$tenantRentStatus['FirstName']} {$tenantRentStatus['LastName']}</td>
                                <td>{$tenantRentStatus['RoomID']}</td>
                                <td>{$tenantRentStatus['FloorNo']}</td>
                                <td>\${$tenantRentStatus['RentalFee']}</td>
                                <td><span style='font-size:1.2em;'>
                                    <a href='#' style='text-decoration:none;color:black;'><i class='far fa-bell'></i></a>
                                </span></td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
    <div class="my-3 p-3 bg-info text-white rounded shadow-sm" style="text-align: initial">
        Tenant List
    </div>
    <table class="table table-info table-striped">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Unit</th>
            <th scope="col">Telephone</th>
            <th scope="col">Email</th>
            <th scope="col">Contract ID</th>
            <th scope="col">No. of Incidents</th>
        </tr>
        </thead>
        <tbody>
            <?php
                foreach ($allTenants as $tenant) {
                    echo "<tr>
                            <td>{$tenant['FirstName']} {$tenant['LastName']}</td>
                            <td>{$tenant['RoomID']}</td>
                            <td>{$tenant['TelephoneNum']}</td>
                            <td>{$tenant['Email']}</td>
                            <td>{$tenant['ContractID']}</td>
                            <td>{$tenant['NumOfIncidents']}</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</main>
<link href="../css/application.css" rel="stylesheet">
<?php include('../views/templates/footer.php'); ?>
