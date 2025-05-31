<?php
    include($filePathPrefix . 'dbConfig.php');

    class Theater {
        function addTheater() {
            $db = new DBconnect();
            $db->MakeConn();
            echo "Connected successfully";
            $db->CloseConn();
        }
    }
?>