<?php
    include('site.Master.php'); // Including the site master page.
    createProperties($filePathPrefix = "./", $pageTitle = "Book a show");
    createHeader($menu = true); // Creating the header.
?>

<?php createContainer(); ?>

<?php
    require_once __DIR__ . '/../src/SmartSeatingAlgorithm/SmartSeatingAlgorithm.php';
 ?>

 <?php
    $alphabet = range('A', 'Z');

    $gridMatrix = [
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0]
    ];

    include('./Booking.php');

    $booking = new Booking();
    $bookings = $booking->getBookings($_POST['showId']);

    foreach ($bookings as $booking) {
        $r = $booking['row'];
        $c = $booking['col'];
        $gridMatrix[$r][$c] = 1;
    }

    $gridMatrix = SmartSeatingAlgorithm::predictSeats(
        $gridMatrix,
        $_POST['audienceType'] ?? "",
        $_POST['theatreSection'] ?? "",
        $_POST['audienceCount'] ?? 1
    );
 ?>

<div style="background-color: #3d3a39; color: white; padding: 20px; padding-top: 40px; padding-bottom: 40px; text-align: center; margin-bottom: 20px;">
    <h2>SCREEN THIS WAY</h2>
</div>

<table class="table table-bordered" style="max-width: 500px; margin: auto;">
    <tr>
        <th class="text-center" height="1%"></th>
            <?php foreach ($gridMatrix[0] as $colIndex => $seat): ?>
                <th class="text-center" style="background-color: #efedec; color: blue;" width="5%"><?php echo $colIndex + 1; ?></th>
            <?php endforeach; ?>
        </tr>
    <?php foreach ($gridMatrix as $rowIndex => $row): ?> 
        <tr>
            <td class="text-center" style="background-color: #efedec; color: blue;" width="1%"><?php echo $alphabet[$rowIndex]; ?></td>
            <?php foreach ($row as $colIndex => $seat): ?>
                <td class="text-center
                    <?php if ($seat === 0): ?>
                        bg-success
                    <?php elseif ($seat === 2): ?>
                        bg-warning
                    <?php else: ?>
                        bg-secondary
                    <?php endif; ?>"
                    width="5%"
                    height="50px"
                    >
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>

<center>
    <form action="booking-confirmation.php" method="post" class="mt-3">
        <input type="hidden" name="matrix" value='<?php echo json_encode($gridMatrix); ?>'>
        <input type="hidden" name="showId" value="<?php echo $_POST['showId']; ?>" />
        <button type="submit" class="btn btn-primary">Book now</button>
    </form>
</center>


<?php closeContainer(); ?>

<?php createFooter(); ?>