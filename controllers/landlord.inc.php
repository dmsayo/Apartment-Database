<?php
    /**
     * Functions that deal with LANDLORD as the logged in user.
     */
    require_once 'connection.inc.php';

    /*
     * Gets Landlord fields from Landlord table and Landlord_Account table.
     * @returns [
     *      'FirstName'=>..., 'LastName'=>..., 'Email'=>..., 'TelephoneNumber'=>...,
     *      'DateOfBirth'=>..., 'SIN'=>..., 'Address'=>...
     * ];
     */
    function getLandlordInfo($conn, $username) {
        $sql_get_landlordInfo = "SELECT la.FirstName, la.LastName, la.Email, la.TelephoneNumber, l.DateOfBirth, l.SIN, ab.Address FROM Landlord l, Landlord_Account la, ApartmentBuilding ab, ApartmentBuilding_Address aba WHERE l.FirstName=la.FirstName AND l.LastName=la.LastName AND la.AccountUsername='$username' AND ab.LandlordSIN=l.SIN AND ab.Address=aba.Address";
        $result_landlordInfo = $conn->query($sql_get_landlordInfo);
        $row_landlordInfo = mysqli_fetch_assoc($result_landlordInfo);
        $landlordInfo = [
            'FirstName' => $row_landlordInfo['FirstName'],
            'LastName' => $row_landlordInfo['LastName'],
            'Email' => $row_landlordInfo['Email'],
            'TelephoneNumber' => $row_landlordInfo['TelephoneNumber'],
            'DateOfBirth' => $row_landlordInfo['DateOfBirth'],
            'SIN' => $row_landlordInfo['SIN'],
            'Address' => $row_landlordInfo['Address']
        ];
        mysqli_free_result($result_landlordInfo);
        return $landlordInfo;
    }

    /* gets total number of tenants for a given landlord (SIN) */
    function getNumberOfTenantsForLandlord($conn, $landlordSIN) {
        $sql_get_totalNumTenants = "SELECT COUNT(*) as TotalNumOfTenants FROM (SELECT DISTINCT t.SIN FROM Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab, Contract c WHERE ab.LandlordSIN=$landlordSIN AND ab.BuildingID=aps.BuildingID AND ta.ApartmentRoomID=aps.RoomID AND t.FirstName=ta.FirstName AND t.LastName=ta.LastName AND ta.ContractID=c.ContractID) AS GroupedTenants";
        $result_totalNumTenants = $conn->query($sql_get_totalNumTenants);
        $totalNumTenants = mysqli_fetch_assoc($result_totalNumTenants)['TotalNumOfTenants'];
        mysqli_free_result($result_totalNumTenants);
        return $totalNumTenants;
    }

    /* gets subtotal of all tenant rents for a given landlord (SIN) */
    function getSubtotalOfAllRents($conn, $landlordSIN) {
        $sql_get_subtotalOfAllRents = "SELECT SUM(GroupedTenants.RentalFee) as SubtotalOfAllRents FROM (SELECT DISTINCT c.RentalFee FROM Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab, Contract c WHERE ab.LandlordSIN=$landlordSIN AND ab.BuildingID=aps.BuildingID AND ta.ApartmentRoomID=aps.RoomID AND t.FirstName=ta.FirstName AND t.LastName=ta.LastName AND ta.ContractID=c.ContractID) AS GroupedTenants";
        $result_subtotalOfAllRents = $conn->query($sql_get_subtotalOfAllRents);
        $subtotalOfAllRents = mysqli_fetch_assoc($result_subtotalOfAllRents)['SubtotalOfAllRents'];
        mysqli_free_result($result_subtotalOfAllRents);
        return $subtotalOfAllRents;
    }

    /* gets Landlord's SIN based on their username */
    function getLandlordSIN($conn, $username) {
        $sql_get_landlordSIN = "SELECT l.SIN FROM Landlord l, Landlord_Account la WHERE AccountUsername='$username' AND l.FirstName=la.FirstName AND l.LastName=la.LastName";
        $result_landlordSIN = $conn->query($sql_get_landlordSIN);
        $landlordSIN = mysqli_fetch_assoc($result_landlordSIN)['SIN'];
        mysqli_free_result($result_landlordSIN);
        return $landlordSIN;
    }

    /* get the average rental fee of landlord's tenants */
    function getAverageRentalFee($conn, $landlordSIN){
        $sql_get_averageRentalFee = "select AVG(c.RentalFee) as AverageRentalFee from Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab, Contract c where l.SIN=$landlordSIN and ab.LandlordSIN=$landlordSIN and ab.BuildingID=aps.BuildingID and ta.ApartmentRoomID=aps.RoomID and t.FirstName=ta.FirstName and t.LastName=ta.LastName and ta.ContractID=c.ContractID group by l.SIN";
        $result_averageRentalFee = $conn->query($sql_get_averageRentalFee);
        $averageRentalFee = mysqli_fetch_assoc($result_averageRentalFee)['AverageRentalFee'];
        mysqli_free_result($result_averageRentalFee);
        return $averageRentalFee;
    }

    /* get tenants' name whose rent is/are below average rental fee */
    function getTenantBelowAverage($conn, $landlordSIN){
        $sql_get_tenantBelowAverage = "select t.FirstName, t.LastName, c.RentalFee from Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab, Contract c where l.SIN=$landlordSIN and ab.LandlordSIN=$landlordSIN and ab.BuildingID=aps.BuildingID and ta.ApartmentRoomID=aps.RoomID and t.FirstName=ta.FirstName and t.LastName=ta.LastName and ta.ContractID=c.ContractID having c.RentalFee < (select AVG(c.RentalFee) from Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab, Contract c where l.SIN=$landlordSIN and ab.LandlordSIN=$landlordSIN and ab.BuildingID=aps.BuildingID and ta.ApartmentRoomID=aps.RoomID and t.FirstName=ta.FirstName and t.LastName=ta.LastName and ta.ContractID=c.ContractID group by l.SIN)";
        $result_tenantBelowAverage = $conn->query($sql_get_tenantBelowAverage);

        $allTenantBelowAverage = [];
        while($row_curr = mysqli_fetch_assoc($result_tenantBelowAverage)){
            $curr_tenant = [
                'FirstName' => $row_curr['FirstName'],
                'LastName'  => $row_curr['LastName'],
                'RentalFee' => $row_curr['RentalFee'],
            ];
            array_push($allTenantBelowAverage,$curr_tenant);
        }
        mysqli_free_result($result_tenantBelowAverage);
        return $allTenantBelowAverage;
    }

     /* get tenants' name whose rent is/are above average rental fee */
    function getTenantAboveAverage($conn, $landlordSIN){
        $sql_get_tenantAboveAverage = "select t.FirstName, t.LastName, c.RentalFee from Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab, Contract c where l.SIN=$landlordSIN and ab.LandlordSIN=$landlordSIN and ab.BuildingID=aps.BuildingID and ta.ApartmentRoomID=aps.RoomID and t.FirstName=ta.FirstName and t.LastName=ta.LastName and ta.ContractID=c.ContractID having c.RentalFee > (select AVG(c.RentalFee) from Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab, Contract c where l.SIN=622035732 and ab.LandlordSIN=622035732 and ab.BuildingID=aps.BuildingID and ta.ApartmentRoomID=aps.RoomID and t.FirstName=ta.FirstName and t.LastName=ta.LastName and ta.ContractID=c.ContractID group by l.SIN)";
        $result_tenantAboveAverage = $conn->query($sql_get_tenantAboveAverage);

        $allTenantAboveAverage = [];
        while($row_curr = mysqli_fetch_assoc($result_tenantAboveAverage)){
            $curr_tenant = [
                'FirstName' => $row_curr['FirstName'],
                'LastName'  => $row_curr['LastName'],
                'RentalFee' => $row_curr['RentalFee'],
            ];
            array_push($allTenantAboveAverage,$curr_tenant);
        }
        mysqli_free_result($result_tenantAboveAverage);
        return $allTenantAboveAverage;
    }

    /*
     * Gets all tenants under specified landlord for the 'Tenants Rent Status' section in landlord homepage.
     * Consumes Landlord SIN to pull data.
     * @returns [
     *      ['FirstName'=>..., 'LastName'=>..., 'RoomID'=>..., 'FloorNo'=>..., 'RentalFee'=>...],
     *      ['FirstName'=>..., 'LastName'=>..., 'RoomID'=>..., 'FloorNo'=>..., 'RentalFee'=>...],
     *      ...
     * ];
     */
    function getAllTenantsRentStatus($conn, $landlordSIN) {
        $sql_get_allTenantsRentStatus = "SELECT DISTINCT t.FirstName, t.LastName, aps.RoomID, aps.FloorNo, c.RentalFee FROM Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab, Contract c WHERE ab.LandlordSIN=$landlordSIN AND ab.BuildingID=aps.BuildingID AND ta.ApartmentRoomID=aps.RoomID AND t.FirstName=ta.FirstName AND t.LastName=ta.LastName AND ta.ContractID=c.ContractID";
        $result_allTenantsRentStatus = $conn->query($sql_get_allTenantsRentStatus);
        $allTenantsRentStatus = [];
        while ($row_curr = mysqli_fetch_assoc($result_allTenantsRentStatus)) {
            $curr_tenant = [
                'FirstName' => $row_curr['FirstName'],
                'LastName' => $row_curr['LastName'],
                'RoomID' => $row_curr['RoomID'],
                'FloorNo' => $row_curr['FloorNo'],
                'RentalFee' => $row_curr['RentalFee']
            ];
            array_push($allTenantsRentStatus, $curr_tenant);
        }
        mysqli_free_result($result_allTenantsRentStatus);
        return $allTenantsRentStatus;
    }

    /*
     * Gets all tenants under specified landlord for the 'Tenants List Section' section in landlord homepage.
     * Consumes Landlord SIN to pull data.
     * @returns [
     *      ['FirstName'=>..., 'LastName'=>..., 'RoomID'=>..., 'TelephoneNum'=>..., 'Email'=>..., 'ContractID'=>..., 'NumOfIncidents'=>...],
     *      ['FirstName'=>..., 'LastName'=>..., 'RoomID'=>..., 'TelephoneNum'=>..., 'Email'=>..., 'ContractID'=>..., 'NumOfIncidents'=>...],
     *      ...
     * ];
     */
    function getAllTenants($conn, $landlordSIN) {
        $sql_get_allTenants = "SELECT DISTINCT t.FirstName, t.LastName, aps.RoomID, ta.TelephoneNum, ta.Email, ta.ContractID, ta.NumOfIncidents FROM Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab WHERE ab.LandlordSIN=$landlordSIN AND ab.BuildingID=aps.BuildingID AND ta.ApartmentRoomID=aps.RoomID AND t.FirstName=ta.FirstName AND t.LastName=ta.LastName";
        $result_allTenants = $conn->query($sql_get_allTenants);
        $allTenants = [];
        while ($row_curr = mysqli_fetch_assoc($result_allTenants)) {
            $curr_tenant = [
                'FirstName' => $row_curr['FirstName'],
                'LastName' => $row_curr['LastName'],
                'RoomID' => $row_curr['RoomID'],
                'TelephoneNum' => $row_curr['TelephoneNum'],
                'Email' => $row_curr['Email'],
                'ContractID' => $row_curr['ContractID'],
                'NumOfIncidents' => $row_curr['NumOfIncidents']

            ];
            array_push($allTenants, $curr_tenant);
        }
        mysqli_free_result($result_allTenants);
        return $allTenants;
    }

    /*
     * Returns the tenant with the given last name, under a given landlord (SIN)
     * @returns empty string on non-matched row
     */
    function getTenantByLastName($conn, $landlordSIN, $tenantLastName) {
        $sql_get_searchedTenant = "SELECT DISTINCT t.FirstName, t.LastName, aps.RoomID, ta.TelephoneNum, ta.Email, ta.ContractID, ta.NumOfIncidents FROM Tenant t, Tenant_Account ta, Landlord l, ApartmentSpace aps, ApartmentBuilding ab WHERE ab.LandlordSIN=$landlordSIN AND ab.BuildingID=aps.BuildingID AND ta.ApartmentRoomID=aps.RoomID AND t.FirstName=ta.FirstName AND t.LastName=ta.LastName AND t.LastName='$tenantLastName'";
        $result_searchedTenant = $conn->query($sql_get_searchedTenant);

        if ($row_searchedTenant = mysqli_fetch_assoc($result_searchedTenant)) {
            $searchedTenant = [
                $row_searchedTenant['FirstName'],
                $row_searchedTenant['LastName'],
                $row_searchedTenant['RoomID'],
                $row_searchedTenant['TelephoneNum'],
                $row_searchedTenant['Email'],
                $row_searchedTenant['ContractID'],
                $row_searchedTenant['NumOfIncidents']
            ];
        } else {
            $searchedTenant = "";
        }
        mysqli_free_result($result_searchedTenant);
        return $searchedTenant;
    }
