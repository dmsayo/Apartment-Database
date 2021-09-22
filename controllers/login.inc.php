<?php
    require_once 'connection.inc.php';
    require_once 'navbar.inc.php';

    function loginHandler() {
        $loginUsername = $_POST["loginUsername"];
        $loginPassword = $_POST["loginPassword"];
        $_SESSION['username'] = $_POST["loginUsername"];
        loginCheck($GLOBALS['conn'], $loginUsername, $loginPassword);
    }

    /*
     * Username and password check for login.
     */
    function loginCheck($conn, $username, $password) {
        $sql = 'SELECT username, password FROM account WHERE username = "' . $username . '"';
        $result = $conn->query($sql);
        $userType = checkUserType($conn, $username);
        $userTypeFilename = ($userType === "tenant") ? "tenantHomepage.php" : "landlordHomepage.php";
        if ($row = mysqli_fetch_assoc($result)) { // check if username exists
            if ($row['password'] === $password) {
                echo "<script>
                        alert('Logging in as $username ...');
                        window.location.href='../views/$userTypeFilename';
                    </script>";
            } else { // incorrect password
                echo "<script>
                        alert('Incorrect password. Try again.);
                        window.location.href='../';
                    </script>";
            }
        } else {
            echo "<script>
                        alert('Username $username does not exist.');
                        window.location.href='../';
                    </script>";
        }
        mysqli_free_result($result);
    }
