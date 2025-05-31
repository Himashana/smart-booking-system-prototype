<?php
    require_once __DIR__ . '/../src/SmartSeatingAlgorithm/SmartSeatingAlgorithm.php';
    require_once __DIR__ . '/../src/SmartSeatingAlgorithm/types.php';

    use PHPUnit\Framework\TestCase;

    class SmartSeatingAlgorithmTest extends TestCase
    {
        public function test_single_orchestra_empty()
        {
            $matrix = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];

            $expected = [
                [1, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            $actual = SmartSeatingAlgorithm::predictSeats($matrix, audienceTypes['SINGLE'], theatreSections['ORCHESTRA'], 1);
            $this->assertEquals($expected, $actual);
        }

        public function test_single_mezzanine_empty()
        {
            $matrix = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            
            $expected = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [1, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            $actual = SmartSeatingAlgorithm::predictSeats($matrix, audienceTypes['SINGLE'], theatreSections['MEZZANINE'], 1);
            $this->assertEquals($expected, $actual);
        }

        public function test_single_balcony_empty()
        {
            $matrix = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            
            $expected = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [1, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            $actual = SmartSeatingAlgorithm::predictSeats($matrix, audienceTypes['SINGLE'], theatreSections['BALCONY'], 1);
            $this->assertEquals($expected, $actual);
        }

        public function test_single_mezzanine_two_empty_inrow()
        {
            $matrix = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [1, 1, 1, 1, 1, 1, 1],
                [1, 1, 0, 0, 1, 1, 1],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            
            $expected = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [1, 1, 1, 1, 1, 1, 1],
                [1, 1, 0, 0, 1, 1, 1],
                [1, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            $actual = SmartSeatingAlgorithm::predictSeats($matrix, audienceTypes['SINGLE'], theatreSections['MEZZANINE'], 1);
            $this->assertEquals($expected, $actual);
        }

        public function test_group_fit_to_row()
        {
            $matrix = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            
            $expected = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [1, 1, 1, 1, 1, 1, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            $actual = SmartSeatingAlgorithm::predictSeats($matrix, audienceTypes['GROUP'], theatreSections['MEZZANINE'], 6);
            $this->assertEquals($expected, $actual);
        }

        public function test_group_exceeded_size()
        {
            $matrix = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            
            $expected = [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [1, 1, 1, 1, 1, 1, 1],
                [1, 1, 1, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0]
            ];
            $actual = SmartSeatingAlgorithm::predictSeats($matrix, audienceTypes['GROUP'], theatreSections['MEZZANINE'], 10);
            $this->assertEquals($expected, $actual);
        }
    }
?>