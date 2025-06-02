<?php
    include($filePathPrefix . 'dbConfig.php');

    class Show {
        function addShow($theaterId, $movieTitle, $showTime) {
            $dbconnection = new DBconnect();
            $dbconnection->MakeConn();
            
            $query = 'INSERT INTO shows (theater_id, movie_title, showtime) VALUES ("' . $theaterId . '", "' . $movieTitle . '", "' . $showTime . '")';
            $result = $dbconnection->ExecuteQuery($query);

            $dbconnection->CloseConn();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        function getShowById($showId) {
            $dbconnection = new DBconnect();
            $dbconnection->MakeConn();
            
            $query = 'SELECT * FROM shows WHERE id = "' . $showId . '"';
            $result = $dbconnection->ExecuteQuery($query);
            $show = mysqli_fetch_assoc($result);

            $dbconnection->CloseConn();

            return $show;
        }

        function getAllShows() {
            $dbconnection = new DBconnect();
            $dbconnection->MakeConn();
            
            $query = 'SELECT * FROM shows';
            $result = $dbconnection->ExecuteQuery($query);
            $shows = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $shows[] = $row;
            }

            $dbconnection->CloseConn();

            return $shows;
        }
    }
?>