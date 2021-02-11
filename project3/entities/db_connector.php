<?php
class Db_connector
{
    var $conn;

    //parameters used to connect to database
    public function __construct($servername = "localhost", $username = "root", $password = "123456", $dbname="book_management_system")
    {
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Error connecting to database: " . $this->conn->error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

?>