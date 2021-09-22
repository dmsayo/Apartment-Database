<?php
    require_once 'connection.inc.php';
    require_once 'functions.inc.php';

    function registerHandler() {
        $name = $_POST["name"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordrpt = $_POST["passwordrpt"];

        if (emptyInputSignup($name, $username, $email, $password, $passwordrpt) !== false) {
            header("location: ../views/register.php?error=emptyinput");
            exit();
        }
        if (invalidUsername($username) !== false) {
            header("location: ../views/register.php?error=invalidusername");
            exit();
        }
        if (invalidEmail($email) !== false) {
            header("location: ../views/register.php?error=invalidemail");
            exit();
        }
        if (passwordDoNotMatch($password, $passwordrpt) !== false) {

            header("location: ../views/register.php?error=passwordnomatch");
            exit();
        }
        if (usernameExists($GLOBALS['conn'], $username) !== false) {
            header("location: ../views/register.php?error=usernametaken");
            exit();
        }
        createUser($GLOBALS['conn'], $name, $username, $password, $email);
    }

    function createUser($conn, $name, $username, $password, $email) {
        $sql = "INSERT INTO account (username, password, email) VALUES (?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../views/register.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../views/register.php?error=none");
        exit();
    }
