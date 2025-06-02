<?php
    include($filePathPrefix . 'dbConfig.php');

    class Booking {
        function saveBooking($showId, $gridMatrix) {
            $dbconnection = new DBconnect();
            $dbconnection->MakeConn();

            foreach ($gridMatrix as $row => $cols) {
                foreach ($cols as $col => $val) {
                    if ($val == 2) {
                        $query = 'INSERT INTO bookings (show_id, row, col) VALUES ("' . $showId . '", "' . $row . '", "' . $col . '")';
                        $result = $dbconnection->ExecuteQuery($query);
                    }
                }
            }

            $dbconnection->CloseConn();
        }

        function getBookings($showId) {
            $dbconnection = new DBconnect();
            $dbconnection->MakeConn();

            $query = 'SELECT row, col FROM bookings WHERE show_id = "' . $showId . '"';
            $result = $dbconnection->ExecuteQuery($query);

            $bookings = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $bookings[] = $row;
            }

            $dbconnection->CloseConn();
            return $bookings;
        }
    }
?>