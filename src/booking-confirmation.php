<?php
    include('site.Master.php'); // Including the site master page.
    createProperties($filePathPrefix = "./", $pageTitle = "Book a show");
    createHeader($menu = true); // Creating the header.
?>

<?php createContainer(); ?>

<?php
    require_once __DIR__ . '/../src/SmartSeatingAlgorithm/SmartSeatingAlgorithm.php';

    $unitPricePerSeat = 120;

    include('./Show.php');

    $show = new Show();
    $showDetails = $show->getShowById($_POST['showId']);
 ?>

<center>
    <div style="border: 1px solid #ccc; background-color:#f7f7f7; padding: 20px; width: 80%; margin-top: 20px;">
        <h2>Confirm Your Booking</h2>
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
                echo "Show: " . $showDetails['movie_title'] . "<br>";
                echo "Show date & time: " . $showDetails['showtime'] . "<br>";
                echo "Selected seats: " . implode(", ", $bookedSeats);
                echo "<br>";
                echo "Total seats: " . count($bookedSeats);
                echo "<br>";
                echo "Total price: LKR" . number_format((count($bookedSeats) * $unitPricePerSeat), 2);
            }
        ?>
        <form action="complete-booking.php" method="post" class="mt-3">
            <input type="hidden" name="matrix" value='<?php echo $_POST['matrix']; ?>'>
            <input type="hidden" name="showId" value="<?php echo $_POST['showId']; ?>" />
            <button type="submit" class="btn btn-success">Book now</button>
        </form>
    </div>
</center>


<?php closeContainer(); ?>

<?php createFooter(); ?>