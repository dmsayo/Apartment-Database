<?php
    /*
     * Used on AJAX request to delete utilities.
     */
    include '../controllers/tenant.inc.php';
    include '../controllers/contract.inc.php';
    connectToDB();
    session_start();
    $tenantUtilityID = getUtilityID($GLOBALS['conn'], $_SESSION['username']);
    deleteAllUtilitiesForATenant($GLOBALS['conn'], $_SESSION['username'], $tenantUtilityID);
    closeConnection();
