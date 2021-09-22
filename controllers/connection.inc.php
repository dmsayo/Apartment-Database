<?php
    include '../util/genericConsoleLog.php';
    include '../util/genericAlert.php';

    /*
     * Connect to database.
     */
    function connectToDB() {
        $SERVER_NAME = 'localhost';
        $SERVER_USERNAME = 'root';
        $SERVER_PASSWORD = 'root';
        $SERVER_DATABASE = 'apartment complex';
        // Create connection
        $GLOBALS['conn'] = new mysqli($SERVER_NAME, $SERVER_USERNAME, $SERVER_PASSWORD, $SERVER_DATABASE);
        if ($GLOBALS['conn']->connect_error) {
            // consoleLogPrimitive("Error connecting to server database.");
            // alertDialogMessage($GLOBALS['conn']->connect_error);
            die();
        } else {
            // consoleLogPrimitive("Connection to $SERVER_DATABASE successful.");
        }
    }

    /*
     * Close database connection.
     */
    function closeConnection() {
        // consoleLogPrimitive("Closing database connection.");
        $GLOBALS['conn']->close();
    }
