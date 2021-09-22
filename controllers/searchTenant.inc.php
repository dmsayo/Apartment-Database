<?php
    /*
     * Used on AJAX request to search for tenants on the landlord homepage.
     */
    include '../controllers/landlord.inc.php';
    connectToDB();
    session_start();
    $searchInput = $_POST['searchInput'];
    $landlordSIN = getLandlordSIN($GLOBALS['conn'], $_SESSION['username']);
    $tenantResult = getTenantByLastName($GLOBALS['conn'], $landlordSIN, $searchInput);
    echo json_encode($tenantResult);
    closeConnection();
