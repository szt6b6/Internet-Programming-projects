<?php

class User
{
    var $userid;
    var $username;
    var $password;
    var $isadmin;

    //id is determined by database, default id set to 0
    public function __construct($userid=0, $username, $password, $isadmin)
    {
        $this->userid = $userid;
        $this->username = $username;
        $this->password = $password;
        $this->isadmin = $isadmin;
    }
}

?>