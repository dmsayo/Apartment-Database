<?php
    /*
     * Returns the user type of the currently logged in user.
     * userType is in ["guest", "tenant", "landlord"]
     */
    function checkUserType($conn, $username) {
        $sql_check_tenant = 'SELECT username FROM Account a JOIN Tenant_Account ta WHERE a.username="'.$username.'" AND a.username=ta.AccountUsername';
        $sql_check_landlord = 'SELECT username FROM Account a JOIN Landlord_Account la WHERE a.username="'.$username.'" AND a.username=la.AccountUsername';
        $result_check_tenant = $conn->query($sql_check_tenant);
        $result_check_landlord = $conn->query($sql_check_landlord);
        if (mysqli_fetch_assoc($result_check_tenant)) {
            // retrieved a row match so we know logged in user is a tenant
            $userType = "tenant";
        } else if (mysqli_fetch_assoc($result_check_landlord)) {
            $userType = "landlord";
        } else {
            // TODO: add access code field to ensure random people don't register, then remove guest block
            $userType = "guest";
        }
        mysqli_free_result($result_check_tenant);
        mysqli_free_result($result_check_landlord);
        return $userType;
    }

    /*
     * Sets navbar accordingly based on $userType.
     * $userType is tenant, landlord, or guest
     */
    function setNavbarView($conn, $username, $userType) {
        if ($userType === "tenant") {
            $sql_tenant = 'SELECT aps.RoomID, aps.FloorNo, aba.Address, aba.City FROM Tenant_Account ta JOIN ApartmentSpace aps';
            $sql_tenant .= ' JOIN ApartmentBuilding ab JOIN ApartmentBuilding_Address aba';
            $sql_tenant .= ' WHERE ta.AccountUsername="'.$username.'"';
            $sql_tenant .= ' AND ta.ApartmentRoomID=aps.RoomID AND aps.BuildingID=ab.BuildingID AND ab.Address=aba.Address';
            $result_tenant = $conn->query($sql_tenant);
            if ($row_tenant = mysqli_fetch_assoc($result_tenant)) {
                echo '<a class="navbar-brand" href="tenantHomepage.php">
                                Room '.$row_tenant['RoomID'].', '.
                    'Floor '.$row_tenant['FloorNo'].
                    ' &nbsp;<small style="font-size:0.6em;">'.
                    $row_tenant['Address'].', '.$row_tenant['City'].
                    '</small></a>';
            }
            mysqli_free_result($result_tenant);
        } else if ($userType === "landlord") {
            $sql_landlord = 'SELECT aba.Address, aba.City, aba.Province, aba.Country FROM ApartmentBuilding ab JOIN ApartmentBuilding_Address aba';
            $sql_landlord .= ' WHERE ab.LandlordSIN=(SELECT SIN FROM Landlord l2, Landlord_Account la';
            $sql_landlord .= ' WHERE la.AccountUsername="'.$username.'" AND l2.FirstName=la.FirstName AND l2.LastName=la.LastName)';
            $sql_landlord .= ' AND ab.Address=aba.Address';
            $result_landlord = $conn->query($sql_landlord);
            if ($row_landlord = mysqli_fetch_assoc($result_landlord)) {
                echo '<a class="navbar-brand" href="landlordHomepage.php">'
                    .$row_landlord['Address']
                    .' &nbsp;<small style="font-size:0.6em;">'
                    .$row_landlord['City'].', '
                    .$row_landlord['Province'].' '
                    .$row_landlord['Country'].
                    '</small></a>';
            }
            mysqli_free_result($result_landlord);
        } else { /* guest */
            echo '<a class="navbar-brand" href="landlordHomepage.php">GUEST</a>';
        }
    }
