<?php
    /**
     * Functions that deal with TENANT as the logged in user.
     */
    require_once 'connection.inc.php';

    /* gets Tenant's SIN based on their username */
    function getTenantSIN($conn, $username) {
        $sql_get_tenantSIN = "SELECT t.SIN FROM Tenant t, Tenant_Account ta WHERE AccountUsername='$username' AND t.FirstName=ta.FirstName AND t.LastName=ta.LastName";
        $result_tenantSIN = $conn->query($sql_get_tenantSIN);
        $tenantSIN = mysqli_fetch_assoc($result_tenantSIN)['SIN'];
        mysqli_free_result($result_tenantSIN);
        return $tenantSIN;
    }

    /*
    * Gets Tenant fields from Tenant table and Tenant_Account table.
    * @returns [
    *      'FirstName'=>..., 'LastName'=>..., 'Email'=>..., 'TelephoneNumber'=>..., 'DateOfBirth'=>..., 'SIN'=>...
    * ];
    */
    function getTenantInfo($conn, $username) {
        $sql_get_tenantInfo = "SELECT ta.FirstName, ta.LastName, ta.Email, ta.TelephoneNum, t.DateOfBirth, t.SIN FROM Tenant t, Tenant_Account ta WHERE t.FirstName=ta.FirstName AND t.LastName=ta.LastName AND ta.AccountUsername='$username'";
        $result_tenantInfo = $conn->query($sql_get_tenantInfo);
        $row_tenantInfo = mysqli_fetch_assoc($result_tenantInfo);
        $tenantInfo = [
            'FirstName' => $row_tenantInfo['FirstName'],
            'LastName' => $row_tenantInfo['LastName'],
            'Email' => $row_tenantInfo['Email'],
            'TelephoneNum' => $row_tenantInfo['TelephoneNum'],
            'DateOfBirth' => $row_tenantInfo['DateOfBirth'],
            'SIN' => $row_tenantInfo['SIN'],
        ];
        mysqli_free_result($result_tenantInfo);
        return $tenantInfo;
    }

    /*
    * Gets all necessary Apartment Information fields for the Tenant profile view.
    * @returns [
    *       'LandlordFirstName'=>..., 'LandlordLastName'=>...,'ContractID'=>..., 'Address'=>...,
    *       'RoomID'=>..., 'FloorNo'=>..., 'NumOfIncidents'=>..., 'LotNumber'=>...
    * ];
    */
    function getTenantApartmentInfo($conn, $username) {
        $sql_get_tenantApartmentInfo = "SELECT l.FirstName as LandlordFirstName, l.LastName as LandlordLastName, c.ContractID, aba.Address, aps.RoomID, aps.FloorNo, ps.LotNumber, ta.NumOfIncidents FROM Landlord l, Tenant t, Tenant_Account ta, ApartmentSpace aps, ApartmentBuilding ab, ApartmentBuilding_Address aba, Contract c, ParkingSpaces ps WHERE ta.AccountUsername='$username' AND ta.ApartmentRoomID=aps.RoomID AND aps.BuildingID=ab.BuildingID AND ab.Address=aba.Address AND l.SIN=ab.LandlordSIN AND c.ContractID=ta.ContractID AND t.FirstName=ta.FirstName AND t.LastName=ta.LastName AND ps.TenantSIN=t.SIN";
        $result_tenantApartmentInfo = $conn->query($sql_get_tenantApartmentInfo);
        $row_tenantApartmentInfo = mysqli_fetch_assoc($result_tenantApartmentInfo);
        $tenantApartmentInfo = [
            'LandlordFirstName' => $row_tenantApartmentInfo['LandlordFirstName'],
            'LandlordLastName' => $row_tenantApartmentInfo['LandlordLastName'],
            'ContractID' => $row_tenantApartmentInfo['ContractID'],
            'Address' => $row_tenantApartmentInfo['Address'],
            'RoomID' => $row_tenantApartmentInfo['RoomID'],
            'FloorNo' => $row_tenantApartmentInfo['FloorNo'],
            'LotNumber' => $row_tenantApartmentInfo['LotNumber'],
            'NumOfIncidents' => $row_tenantApartmentInfo['NumOfIncidents']
        ];
        mysqli_free_result($result_tenantApartmentInfo);
        return $tenantApartmentInfo;
    }

    /*
     * Gets all attributes for a given address.
     * @returns ['Address'=>..., 'City'=>..., 'Province'=>..., 'Country'=>...];
     */
    function getFullAddress($conn, $address) {
        $sql_get_fullAddress = "SELECT ab.Address, ab.City, ab.Province, ab.Country FROM ApartmentBuilding_Address ab WHERE ab.Address='$address'";
        $result_fullAddress = $conn->query($sql_get_fullAddress);
        $row_fullAddress = mysqli_fetch_assoc($result_fullAddress);
        $fullAddress = [
            'Address' => $row_fullAddress['Address'],
            'City' => $row_fullAddress['City'],
            'Province' => $row_fullAddress['Province'],
            'Country' => $row_fullAddress['Country']
        ];
        mysqli_free_result($result_fullAddress);
        return $fullAddress;
    }
