<?php
    include('site.Master.php'); // Including the site master page.
    createProperties($filePathPrefix = "", $pageTitle = "Book a show");
    createHeader($menu = true); // Creating the header.
?>

<?php createContainer(); ?>

<?php require_once __DIR__ . '/SmartSeatingAlgorithm/types.php'; ?>

    <?php
        $initSeatsCount = 1;
        if (isset($_POST['audienceType'])) {
            if (audienceTypes['SINGLE'] === $_POST['audienceType']) {
                $initSeatsCount = 1;
            } elseif (audienceTypes['COUPLE'] === $_POST['audienceType']) {
                $initSeatsCount = 2;
            }
        }
    ?>

    <form action="select-section.php" method="post" class="mb-3">
        <input type="hidden" name="audienceType" value="<?php echo $_POST['audienceType'] ?? ''; ?>">
        <input type="number" name="audienceCount" value="<?php echo $initSeatsCount; ?>" class="form-control" placeholder="Enter number of audience" required>

        <button type="submit" class="btn btn-primary mt-3 w-100">Next</button>
    </form>

<?php closeContainer(); ?>

<?php createFooter(); ?>