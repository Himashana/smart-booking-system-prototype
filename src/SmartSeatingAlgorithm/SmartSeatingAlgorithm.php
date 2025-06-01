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
                        if (!(self::getAvailableSeatsInRow($gridMatrix[$row]) == 2 && self::isCloserSeatsAvailable($gridMatrix[$row]))){
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
                        if (!(self::getAvailableSeatsInRow($gridMatrix[$row]) == 2 && self::isCloserSeatsAvailable($gridMatrix[$row]))){
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
                        if (!(self::getAvailableSeatsInRow($gridMatrix[$row]) == 2 && self::isCloserSeatsAvailable($gridMatrix[$row]))){
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
                $subset = array_slice($gridMatrix, 2, 4);
                $baseIndex = 2;
                $insetCount = 0;

                if ($theatreSection == theatreSections['ORCHESTRA']) {
                    for ($row = 0; $row < 2; $row++) {
                        if (self::getAvailableSeatsInRow($gridMatrix[$row]) == $audienceCount && self::isCloserSeatsAvailable($gridMatrix[$row], $audienceCount)) {
                            for ($col = 0; $col < count($gridMatrix[$row]); $col++) {
                                if ($gridMatrix[$row][$col] == 0) {
                                    $gridMatrix[$row][$col] = 1;
                                    $insetCount++;
                                    if ($insetCount >= $audienceCount) {
                                        return $gridMatrix;
                                    }
                                }
                            }
                        }
                    }

                    // Insert into row with minimum availability:
                    $rowWithMinAvailability = self::getRowWithMinimumAvailability(array_slice($gridMatrix, 0, 2), $audienceCount);
                    if ($rowWithMinAvailability) {
                        for ($col = 0; $col < count($rowWithMinAvailability); $col++) {
                            if ($rowWithMinAvailability[$col] == 0) {
                                $gridMatrix[array_search($rowWithMinAvailability, $gridMatrix)][$col] = 1;
                                $insetCount++;
                                if ($insetCount >= $audienceCount) {
                                    return $gridMatrix;
                                }
                            }
                        }
                    }

                    for ($row = 0; $row < count($gridMatrix); $row++) {
                        for ($col = 0; $col < count($gridMatrix[$row]); $col++) {
                            if ($gridMatrix[$row][$col] == 0 && !self::isSpecialSeat($row, $col)) {
                                $gridMatrix[$row][$col] = 1;
                                return $gridMatrix;
                            }
                        }
                    }
                } elseif ($theatreSection == theatreSections['MEZZANINE']) {
                    for ($row = 2; $row < 5; $row++) {
                        if (self::getAvailableSeatsInRow($gridMatrix[$row]) == $audienceCount && self::isCloserSeatsAvailable($gridMatrix[$row], $audienceCount)) {
                            for ($col = 0; $col < count($gridMatrix[$row]); $col++) {
                                if ($gridMatrix[$row][$col] == 0) {
                                    $gridMatrix[$row][$col] = 1;
                                    $insetCount++;
                                    if ($insetCount >= $audienceCount) {
                                        return $gridMatrix;
                                    }
                                }
                            }
                        }
                    }

                    // Insert into row with minimum availability:
                    $rowWithMinAvailability = self::getRowWithMinimumAvailability($subset, $audienceCount);
                    if ($rowWithMinAvailability) {
                        $insetCount = 0;
                        foreach ($subset as $offset => $row) {
                            if ($row === $rowWithMinAvailability) {
                                $actualRowIndex = $baseIndex + $offset;
                                for ($col = 0; $col < count($row); $col++) {
                                    if ($gridMatrix[$actualRowIndex][$col] == 0) {
                                        $gridMatrix[$actualRowIndex][$col] = 1;
                                        $insetCount++;
                                        if ($insetCount >= $audienceCount) {
                                            return $gridMatrix;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // for ($row = 0; $row < count($gridMatrix); $row++) {
                    //     for ($col = 0; $col < count($gridMatrix[$row]); $col++) {
                    //         if ($gridMatrix[$row][$col] == 0 && !self::isSpecialSeat($row, $col)) {
                    //             $gridMatrix[$row][$col] = 1;
                    //             return $gridMatrix;
                    //         }
                    //     }
                    // }
                }
            }

            return $gridMatrix;
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

        // Check for is only given no. of closer seats available in a row
        private static function isCloserSeatsAvailable($row, $closerSeatsCount = 2) {
            $count = 0;
            for ($col = 0; $col < count($row); $col++) {
                if ($row[$col] == 0 && !self::isSpecialSeat($row, $col)) {
                    $count++;
                    if ($count >= $closerSeatsCount) {
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
                if ($seat == 0 && !self::isSpecialSeat($row, array_search($seat, $row))) {
                    $count++;
                }
            }
            return $count;
        }

        // Take multiple rows and return row with minimum possible availability for given number of seats (all are close together)
        public static function getRowWithMinimumAvailability($rows, $audienceCount) {
            $minRow = null;
            $minCount = PHP_INT_MAX;

            foreach ($rows as $row) {
                $availableSeats = self::getAvailableSeatsInRow($row);
                if ($availableSeats >= $audienceCount && $availableSeats < $minCount) {
                    $minCount = $availableSeats;
                    $minRow = $row;
                }
            }

            return $minRow;
        }
   }
?>