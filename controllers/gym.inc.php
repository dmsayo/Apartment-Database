<?php

function searchTreadmillGyms($conn) {
    $sql = "SELECT distinct RoomID FROM gymcontains WHERE GymEquipmentID = '1'";
    $result = $conn->query($sql);
    
    while ($row = $row = mysqli_fetch_array($result)) {
        echo "<p> Gym in room " . $row['RoomID'] . " has a treadmill </p>" ;
    }
}

function searchKettlebellGyms($conn) {
    $sql = "SELECT distinct RoomID FROM gymcontains WHERE GymEquipmentID = '2'";
    $result = $conn->query($sql);
    
    while ($row = $row = mysqli_fetch_array($result)) {
        echo "<p> Gym in room " . $row['RoomID'] . " has kettlebells </p>" ;
    }
}

function searchDumbellGyms($conn) {
    $sql = "SELECT distinct RoomID FROM gymcontains WHERE GymEquipmentID = '3'";
    $result = $conn->query($sql);
    
    while ($row = $row = mysqli_fetch_array($result)) {
        echo "<p> Gym in room " . $row['RoomID'] . " has a dumbell rack </p>" ;
    }
}

function searchBicycleGyms($conn) {
    $sql = "SELECT distinct RoomID FROM gymcontains WHERE GymEquipmentID = '4'";
    $result = $conn->query($sql);
    
    while ($row = $row = mysqli_fetch_array($result)) {
        echo "<p> Gym in room " . $row['RoomID'] . " has a staionary bicycle </p>" ;
    }
}

function searchWeightsGyms($conn) {
    $sql = "SELECT distinct RoomID FROM gymcontains WHERE GymEquipmentID = '5'";
    $result = $conn->query($sql);
    
    while ($row = $row = mysqli_fetch_array($result)) {
        echo "<p> Gym in room " . $row['RoomID'] . " has 45 lbs. weights </p>" ;
    }
}

function searchCompleteGyms($conn) {
    $sql = "SELECT distinct RoomID FROM facilities f WHERE NOT EXISTS ((SELECT EquipmentID FROM gymequipment) EXCEPT (SELECT gc.GymEquipmentID FROM gymcontains gc, gymequipment ge, gym g WHERE g.RoomID = f.RoomID AND g.RoomID = gc.RoomID));";
    $result = $conn->query($sql);
    
    while ($row = $row = mysqli_fetch_array($result)) {
        echo "<p> Gym in room " . $row['RoomID'] . " has all of the above equipment </p>" ;
    }
}