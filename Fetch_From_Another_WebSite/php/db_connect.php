<?php
/**
 * Created by PhpStorm.
 * User: yaojean-elisee
 * Date: 13/05/2018
 * Time: 02:29
 */

function createConnexion()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "from_nouchi.com";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error)
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    else
        return $conn;
}