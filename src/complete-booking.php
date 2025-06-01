<?php
    include('site.Master.php'); // Including the site master page.
    createProperties($filePathPrefix = "./", $pageTitle = "Complete Booking");
    createHeader($menu = true); // Creating the header.
?>

<?php createContainer(); ?>

<?php
    require_once __DIR__ . '/../src/SmartSeatingAlgorithm/SmartSeatingAlgorithm.php';

    $unitPricePerSeat = 120;
    $gridMatrix = json_decode($_POST['matrix'], true);

    include('./Booking.php');

    $booking = new Booking();
    $showId = $_POST['showId'];

    // Save the booking
    $booking->saveBooking($showId, $gridMatrix);
 ?>

<center>
    <div style="border: 1px solid #ccc; background-color:#f7f7f7; padding: 20px; width: 80%; margin-top: 20px;">
        <h2>Booking Successful</h2>
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $matrix = json_decode($_POST['matrix'], true);

                $bookedSeats = [];

                foreach ($matrix as $row => $cols) {
                    foreach ($cols as $col => $val) {
                        if ($val == 2) {
                            // Convert row numbers to letters
                            $rowLetter = chr(65 + $row);
                            $seat = $rowLetter . ($col + 1);
                            $bookedSeats[] = $seat;
                        }
                    }
                }
                echo "Selected seats: " . implode(", ", $bookedSeats);
                echo "<br>";
                echo "Total seats: " . count($bookedSeats);
                echo "<br>";
                echo "Total price: LKR" . number_format((count($bookedSeats) * $unitPricePerSeat), 2);
            }
        ?>
    </div>
</center>


<?php closeContainer(); ?>

<?php createFooter(); ?>