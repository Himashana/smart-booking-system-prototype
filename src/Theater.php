<?php
    include($filePathPrefix . 'dbConfig.php');

    class Theater {
        function addTheater($name, $rows, $columns) {
            $dbconnection = new DBconnect();
            $dbconnection->MakeConn();
            
            $query = 'INSERT INTO theaters (name, t_rows, t_cols) VALUES ("' . $name . '", ' . $rows . ', ' . $columns . ')';
            $result = $dbconnection->ExecuteQuery($query);

            $dbconnection->CloseConn();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        function getTheaterById($id) {
            $dbconnection = new DBconnect();
            $dbconnection->MakeConn();
            
            $query = 'SELECT * FROM theaters WHERE id = ' . $id;
            $result = $dbconnection->ExecuteQuery($query);

            if ($row = mysqli_fetch_assoc($result)) {
                $dbconnection->CloseConn();
                return $row;
            } else {
                $dbconnection->CloseConn();
                return null;
            }
        }

        function getTheaters() {
            $dbconnection = new DBconnect();
            $dbconnection->MakeConn();
            
            $query = 'SELECT * FROM theaters';
            $result = $dbconnection->ExecuteQuery($query);

            $theaters = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $theaters[] = $row;
            }

            $dbconnection->CloseConn();

            return $theaters;
        }
    }
?>