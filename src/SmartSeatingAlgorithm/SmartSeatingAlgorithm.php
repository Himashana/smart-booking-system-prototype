<!-- Disable accessing normally through the web browser -->
<?php
   if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
       die("Access denied.");
   }

    require_once __DIR__ . '/types.php';
?>

<?php
   class SmartSeatingAlgorithm {
        // Static data for special seats allocation for now
        private static $seatsForDisabledPeople = [[4, 5], [4, 6]];
        private static $seatsForVIP = [[6, 0], [6, 1], [6, 5], [6, 6]];

        public static function predictSeats(
            $gridMatrix,
            $audienceType,
            $theatreSection,
            $audienceCount,
        ){
            if ($audienceType == audienceTypes['SINGLE']){
                // Set 1 in the first avaiable seat for the specific section in the matrix
                if ($theatreSection == theatreSections['ORCHESTRA']) {
                    for ($row = 0; $row < count($gridMatrix); $row++) {
                        if (!(self::getAvailableSeatsInRow($gridMatrix[$row]) == 2 && self::isTwoCloserSeatsAvailable($gridMatrix[$row]))){
                            for ($col = 0; $col < count($gridMatrix[$row]); $col++) {
                                if ($gridMatrix[$row][$col] == 0 && !self::isSpecialSeat($row, $col)) {
                                    $gridMatrix[$row][$col] = 1;
                                    return $gridMatrix;
                                }
                            }
                        }
                    }
                } elseif ($theatreSection == theatreSections['MEZZANINE']) {
                    // Start allocation from the 3rd row
                    for ($row = 2; $row < count($gridMatrix); $row++) {
                        if (!(self::getAvailableSeatsInRow($gridMatrix[$row]) == 2 && self::isTwoCloserSeatsAvailable($gridMatrix[$row]))){
                            for ($col = 0; $col < count($gridMatrix[$row]); $col++) {
                                if ($gridMatrix[$row][$col] == 0 && !self::isSpecialSeat($row, $col)) {
                                    $gridMatrix[$row][$col] = 1;
                                    return $gridMatrix;
                                }
                            }
                        }
                    }
                } elseif ($theatreSection == theatreSections['BALCONY']) {
                    // Start allocation from the 4th row
                    for ($row = 5; $row < count($gridMatrix); $row++) {
                        if (!(self::getAvailableSeatsInRow($gridMatrix[$row]) == 2 && self::isTwoCloserSeatsAvailable($gridMatrix[$row]))){
                            for ($col = 0; $col < count($gridMatrix[$row]); $col++) {
                                if ($gridMatrix[$row][$col] == 0 && !self::isSpecialSeat($row, $col)) {
                                    $gridMatrix[$row][$col] = 1;
                                    return $gridMatrix;
                                }
                            }
                        }
                    }
                }
            } elseif ($audienceType == audienceTypes['GROUP']) {

            }
        }

        private static function isSpecialSeat($row, $col){
            // Check if the seat is for disabled people
            foreach (self::$seatsForDisabledPeople as $seat) {
                if ($seat[0] == $row && $seat[1] == $col) {
                    return true;
                }
            }

            // Check if the seat is for VIP
            foreach (self::$seatsForVIP as $seat) {
                if ($seat[0] == $row && $seat[1] == $col) {
                    return true;
                }
            }

            return false;
        }

        // Check for is only two closer seats available in a row
        private static function isTwoCloserSeatsAvailable($row){
            $count = 0;
            for ($col = 0; $col < count($row); $col++) {
                if ($row[$col] == 0 && !self::isSpecialSeat($row, $col)) {
                    $count++;
                    if ($count >= 2) {
                        return true;
                    }
                } else {
                    $count = 0; // Reset count if a seat is occupied or special
                }
            }
            return false;
        }

        // Get number of available seats in a row
        public static function getAvailableSeatsInRow($row) {
            $count = 0;
            foreach ($row as $seat) {
                if ($seat == 0) {
                    $count++;
                }
            }
            return $count;
        }
   }
?>