<?php
    include($filePathPrefix . 'dbConfig.php');

    class Theater {
        function addTheater() {
            $dbconnection = new DBconnect();
            $dbconnection->MakeConn();
            echo "Connected successfully";
            $dbconnection->CloseConn();
        }
    }
?>