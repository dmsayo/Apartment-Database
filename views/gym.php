<?php
include '../views/templates/header.php';
include '../views/templates/navbar.php';
include '../controllers/gym.inc.php';

connectToDB();
$userType = checkUserType($GLOBALS['conn'], $_SESSION['username']);
$currUsername = $_SESSION['username'];
closeConnection();
?>

<main class="container pb-3">
    <div class="d-flex p-3 my-3 text-white bg-secondary rounded shadow-sm">
        <div class="lh-1">
            <h4 class="mb-0 text-white lh-1">Gym Information</h4>
        </div>
    </div>
    <div class="my-3 p-3 bg-body rounded shadow-sm" style="text-align: initial">
        <div>
            <h5>
                Results

            </h5>
        </div>
        <hr />

        <?php
        connectToDB();
        if (isset($_POST['equip'])) {
            if ($_POST['equip'] === 'treadmill') {
                searchTreadmillGyms($GLOBALS['conn']);
            } else if ($_POST['equip'] === 'kettlebell') {
                searchKettlebellGyms($GLOBALS['conn']);
            } else if ($_POST['equip'] === 'dumbell') {
                searchDumbellGyms($GLOBALS['conn']);
            } else if ($_POST['equip'] === 'bicycle') {
                searchBicycleGyms($GLOBALS['conn']);
            } else if ($_POST['equip'] === 'weights') {
                searchWeightsGyms($GLOBALS['conn']);
            } else if ($_POST['equip'] === 'all') {
                searchCompleteGyms($GLOBALS['conn']);
            }
        }
        closeConnection();
        ?>

        <hr />

        <div>
            <h5>
                Search for Equipment Here
            </h5>
            <hr />
            <form method="POST" action="../views/gym.php" id="searchGym">
                <table class="table profileTables">
                    <tbody>
                        <tr>
                            <th class="col-3" scope="row">Equipment Type</th>
                            <td>
                                <select class="form-select" name="equip">
                                    <option value="treadmill">Treadmill</option>
                                    <option value="kettlebell">Kettlebell</option>
                                    <option value="dumbell">Dumbell Rack</option>
                                    <option value="bicycle">Bicycle</option>
                                    <option value="weights">45 lbs. Weights</option>
                                    <option value="all">All</option>
                                </select>
                            </td>
                        </tr>


                    </tbody>
                </table>
        </div>
        <button class="register-btn w-100 btn btn-lg btn-success" type="submit" id="searchGym" name="searchGym" value="Submit" form="searchGym">Submit Search</button>
        </form>

    </div>

</main>

<link href="../css/application.css" rel="stylesheet">
<?php include('../views/templates/footer.php'); ?>