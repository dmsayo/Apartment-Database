<?php
    require_once 'connection.inc.php';
    require_once 'editProfile.inc.php';

    /*
     * Gets contract attributes StartDate, EndDate, and RentalFee.
     * @returns attributes as an associative array
     */
    function getContractAttributes($conn, $username) {
        $contractID = getContractID($conn, $username);
        $sql_get_contract_attrs = "SELECT StartDate, EndDate, RentalFee FROM Contract WHERE ContractID=$contractID";
        $result_contract_attrs = $conn->query($sql_get_contract_attrs);
        $row_contract_attrs = mysqli_fetch_assoc($result_contract_attrs);
        $contractAttrs = [
            'StartDate' => $row_contract_attrs['StartDate'],
            'EndDate' => $row_contract_attrs['EndDate'],
            'RentalFee' => $row_contract_attrs['RentalFee']
        ];
        mysqli_free_result($result_contract_attrs);
        return $contractAttrs;
    }

    /* gets UtilityID from tenant's contract */
    function getUtilityID($conn, $username) {
        $contractID = getContractID($conn, $username);
        $sql_get_utilityid = "SELECT UtilityID FROM TracksUsage WHERE ContractID=$contractID";
        $result_utilityid = $conn->query($sql_get_utilityid);
        $utilityID = [];
        if (mysqli_num_rows($result_utilityid) > 0) {
            $utilityID = mysqli_fetch_assoc($result_utilityid)['UtilityID'];
            mysqli_free_result($result_utilityid);
            return $utilityID;
        } else {
            return "";
        }
    }

    /*
     * deletes all utilities for a given utility ID
     * ON CASCADE DELETES on its sub tables (gas, internet, electricity, hydro)
     */
    function deleteAllUtilitiesForATenant($conn, $username, $utilityID) {
        $utilityID = getUtilityID($conn, $username);
        $sql_delete_utilityid = "DELETE FROM Utilities WHERE UtilityID=$utilityID";
        $result_delete_utilityid = $conn->query($sql_delete_utilityid);
        mysqli_free_result($result_delete_utilityid);
    }

    /* gets PricePerUnit from tenant's contract */
    function getPricePerUnit($conn, $username) {
        $contractID = getContractID($conn, $username);
        $sql_get_pricePerUnit = "SELECT PricePerUnit FROM TracksUsage, Utilities WHERE ContractID=$contractID";
        $result_pricePerUnit = $conn->query($sql_get_pricePerUnit);
        $pricePerUnit = mysqli_fetch_assoc($result_pricePerUnit)['PricePerUnit'];
        mysqli_free_result($result_pricePerUnit);
        return $pricePerUnit;
    }

    /* executes SQL query to grab specified Utilities ISA attributes */
    function executeUtilitiesQuery($conn, $username, $table, $attr) {
        $utilityID = getUtilityID($conn, $username);
        $sql_get_attr = "SELECT $attr FROM $table WHERE UtilityID=$utilityID";
        $result_attr = $conn->query($sql_get_attr);
        $attr_value = mysqli_fetch_assoc($result_attr)[$attr];
        mysqli_free_result($result_attr);
        return $attr_value;
    }

    /* gets gas usage as AmtGasConsumed */
    function getGasUsage($conn, $username) {
        return executeUtilitiesQuery($conn, $username, "Gas", "AmtGasConsumed");
    }

    /* gets internet usage as MonthsPaid */
    function getInternetUsage($conn, $username) {
        return executeUtilitiesQuery($conn, $username, "Internet", "MonthsPaid");
    }

    /* gets electricity usage as kWhConsumed */
    function getElectricityUsage($conn, $username) {
        return executeUtilitiesQuery($conn, $username, "Electricity", "kWhConsumed");
    }

    /* gets hydro usage as WaterConsumed */
    function getHydroUsage($conn, $username) {
        return executeUtilitiesQuery($conn, $username, "Hydro", "WaterConsumed");
    }
