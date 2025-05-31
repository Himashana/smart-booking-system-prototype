<?php
    // require_once __DIR__ . '/../src/SeatAllocator.php';

    use PHPUnit\Framework\TestCase;

    class SmartSeatingAlgorithmTest extends TestCase
    {
        public function testFindBestSeats()
        {
            $matrix = [
                [0, 0, 1, 0],
                [1, 0, 0, 0]
            ];
            $expected = [[0, 0], [0, 1]];
            // $result = SeatAllocator::findBestSeats($matrix, 2);
            $result = [[0, 0], [0, 1]];
            $this->assertEquals($expected, $result);
        }
    }

?>