<?php
    /* --- login,register validation functions --- */
    function emptyInputSignup($name, $username, $email, $password, $passwordrpt)
    {
        if (empty($name) || empty($username) || empty($email) || empty($password) || empty($passwordrpt)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function invalidUsername($username)
    {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function invalidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function passwordDoNotMatch($password, $passwordrpt)
    {
        if ($password != $passwordrpt) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function usernameExists($conn, $username)
    {
        $sql = "SELECT * FROM account WHERE username = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../views/register.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($resultData)) {
            mysqli_stmt_close($stmt);
            return $row;
        } else {
            mysqli_stmt_close($stmt);
            return false;
        }
    }
    /* ---------------------- */
