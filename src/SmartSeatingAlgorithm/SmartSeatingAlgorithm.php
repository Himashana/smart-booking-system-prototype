<!-- Disable accessing normally through the web browser -->
<?php
   if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
       die("Access denied.");
   }

    require_once __DIR__ . '/types.php';
?>

<?php
   class SmartSeatingAlgorithm {
        // Note: Matrix values: 0 = empty seat, 1 = booked seat, 2 = predicted seat
        
        // Static data for special seats allocation for now
        private static $seatsForDisabledPeople = [[4, 5], [4, 6]];
        private static $seatsForVIP = [[6, 0], [6, 1], [6, 5], [6, 6]];

        public static function predictSeats(
            $gridMatrix,
            $audienceType,
            $theatreSection,
            $audienceCount,
        ){
            $subset = array_slice($gridMatrix, 0, 2);
            $baseIndex = 0;

            if ($theatreSection == theatreSections['ORCHESTRA']) {
                $subset = array_slice($gridMatrix, 0, 2);
                $baseIndex = 0;
            } elseif ($theatreSection == theatreSections['MEZZANINE']) {
                $subset = array_slice($gridMatrix, 2, 4);
                $baseIndex = 2;
            } elseif ($theatreSection == theatreSections['BALCONY']) {
                $subset = array_slice($gridMatrix, 5, 6);
                $baseIndex = 5;
            }

            if ($audienceType == audienceTypes['PATRON']) {
                $subset = array_slice($gridMatrix, 4, 6);
                $baseIndex = 4;

                // Follow the same logic as for GROUP audience type within the specific section for patrons as they may come as groups
                $audienceType = audienceTypes['GROUP'];
            }

            if ($audienceType == audienceTypes['SINGLE']){
                // Set 1 in the first avaiable seat for the specific section in the matrix
                foreach ($subset as $offset => $row) {
                    $actualRowIndex = $baseIndex + $offset;
                    if (!(self::getAvailableSeatsInRow($row) == 2 && self::isCloserSeatsAvailable($row))){
                        for ($col = 0; $col < count($row); $col++) {
                            if ($gridMatrix[$actualRowIndex][$col] == 0 && !self::isSpecialSeat($actualRowIndex, $col)) {
                                $gridMatrix[$actualRowIndex][$col] = 2;
                                return $gridMatrix;
                            }
                        }
                    }
                }

                // If no normal seats are available, allocate the special seats
                if (!self::isAnyNormalSeatAvailable($gridMatrix)) {
                    for ($row = 0; $row < count($gridMatrix); $row++) {
                        for ($col = 0; $col < count($gridMatrix[$row]); $col++) {
                            if ($gridMatrix[$row][$col] == 0 && self::isSpecialSeat($row, $col)) {
                                $gridMatrix[$row][$col] = 2;
                                return $gridMatrix;
                            }
                        }
                    }
                }
            } elseif ($audienceType == audienceTypes['GROUP']) {
                $insetCount = 0;
                foreach ($subset as $offset => $row) {
                    if (
                        self::getAvailableSeatsInRow($row) == $audienceCount &&
                        self::isCloserSeatsAvailable($row, $audienceCount)
                    ) {
                        $actualRowIndex = $baseIndex + $offset;
                        for ($col = 0; $col < count($row); $col++) {
                            if ($gridMatrix[$actualRowIndex][$col] == 0) {
                                $gridMatrix[$actualRowIndex][$col] = 2;
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
                                    $gridMatrix[$actualRowIndex][$col] = 2;
                                    $insetCount++;
                                    if ($insetCount >= $audienceCount) {
                                        return $gridMatrix;
                                    }
                                }
                            }
                        }
                    }
                }

                // Insert into row with maximum availability and move to next available line to fill the exceeded count
                $rowWithMaxAvailability = self::getRowWithMaximumAvailability($subset);
                if ($rowWithMaxAvailability) {
                    $insetCount = 0;

                    // Get the index of the max availability row in the gridMatrix
                    $startOffset = null;
                    foreach ($subset as $offset => $row) {
                        if ($row === $rowWithMaxAvailability) {
                            $startOffset = $offset;
                            break;
                        }
                    }

                    // Insert from that row and continue through next rows for the exceeded count
                    for ($i = $startOffset; $i < count($subset); $i++) {
                        $actualRowIndex = $baseIndex + $i;

                        for ($col = 0; $col < count($gridMatrix[$actualRowIndex]); $col++) {
                            if ($gridMatrix[$actualRowIndex][$col] == 0) {
                                $gridMatrix[$actualRowIndex][$col] = 2;
                                $insetCount++;

                                if ($insetCount >= $audienceCount) {
                                    return $gridMatrix;
                                }
                            }
                        }
                    }
                }
            } elseif ($audienceType == audienceTypes['COUPLE']) {
                // Book first two available seats for the specific section in the matrix
                foreach ($subset as $offset => $row) {
                    $actualRowIndex = $baseIndex + $offset;
                    $insetCount = 0;

                    if (self::getAvailableSeatsInRow($row) >= 2 && self::isCloserSeatsAvailable($row, 2)){
                        for ($col = 0; $col < count($row); $col++) {
                            // Check if the next closer seat is also available
                            if ($gridMatrix[$actualRowIndex][$col] == 0 && ($insetCount < $audienceCount && $gridMatrix[$actualRowIndex][$col + 1] == 0)) {
                                $gridMatrix[$actualRowIndex][$col] = 2;
                                $insetCount++;
                                if ($insetCount >= $audienceCount) {
                                    return $gridMatrix;
                                }
                            }
                        }
                    }
                }
            } elseif ($audienceType == audienceTypes['VIP']) {
                // Book the first available VIP seat
                foreach (self::$seatsForVIP as $seat) {
                    if ($gridMatrix[$seat[0]][$seat[1]] == 0) {
                        $gridMatrix[$seat[0]][$seat[1]] = 2;
                        return $gridMatrix;
                    }
                }
            } elseif ($audienceType == audienceTypes['DISABLED_PERSON']) {
                // Reorder $seatsForDisabledPeople from lower row to higher row and from higher column to lower column
                usort(self::$seatsForDisabledPeople, function ($a, $b) {
                    if ($a[0] == $b[0]) {
                        return $b[1] - $a[1];
                    }
                    return $a[0] - $b[0];
                });

                foreach (self::$seatsForDisabledPeople as $seat) {
                    if ($gridMatrix[$seat[0]][$seat[1]] == 0) {
                        $gridMatrix[$seat[0]][$seat[1]] = 2;
                        return $gridMatrix;
                    }
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
        private static function getAvailableSeatsInRow($row) {
            $count = 0;
            foreach ($row as $seat) {
                if ($seat == 0 && !self::isSpecialSeat($row, array_search($seat, $row))) {
                    $count++;
                }
            }
            return $count;
        }

        // Take multiple rows and return row with minimum possible availability for given number of seats (all are close together)
        private static function getRowWithMinimumAvailability($rows, $audienceCount) {
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

        private static function getRowWithMaximumAvailability($rows) {
            // Insert the available seats count of each row into an array
            $maxRow = null;
            $maxCount = 0;

            foreach ($rows as $row) {
                $availableSeats = self::getAvailableSeatsInRow($row);
                if ($availableSeats > $maxCount) {
                    $maxCount = $availableSeats;
                    $maxRow = $row;
                }
            }

            return $maxRow;
        }

        private static function isAnyNormalSeatAvailable($gridMatrix) {
            foreach ($gridMatrix as $rowIndex => $row) {
                foreach ($row as $colIndex => $seat) {
                    if ($seat === 0 && !self::isSpecialSeat($rowIndex, $colIndex)) {
                        return true;
                    }
                }
            }
            return false;
        }
   }
?>