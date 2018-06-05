<?php
/**
 * Created by PhpStorm.
 * User: yaojean-elisee
 * Date: 04/06/2018
 * Time: 20:02
 */

final class WordDbHelper
{
    const SERVER_NAME = 'localhost';
    const USERNAME = 'root';
    const PASSWORD = 'root';
    const DB_NAME = 'from_nouchi.com';

    /**
     * WordDbHelper constructor.
     */
    public function __construct()
    {

    }

    public function getConnexion()
    {
        // Create connection
        $conn = new mysqli(
            WordDbHelper::SERVER_NAME,
            WordDbHelper::USERNAME,
            WordDbHelper::PASSWORD,
            WordDbHelper::DB_NAME
        );

        // Check connection
        if ($conn->connect_error)
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        else
            return $conn;
    }
}