<?php
    /*
     * Logs primitive php variables onto the browser console.
     */
    function consoleLogPrimitive($var) {
        echo "<script>console.log('$var')</script>";
    }

    /*
     * Logs array php variables onto the browser console.
     */
    function consoleLogArray($var) {
        echo "<script>console.log(JSON.parse('" . json_encode($var) . "'))</script>";
    }
