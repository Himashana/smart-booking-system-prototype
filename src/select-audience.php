<?php
    include('site.Master.php'); // Including the site master page.
    createProperties($filePathPrefix = "", $pageTitle = "Book a show");
    createHeader($menu = true); // Creating the header.
?>

<?php createContainer(); ?>

<?php require_once __DIR__ . '/SmartSeatingAlgorithm/types.php'; ?>

<?php
    if (!isset($_GET['show_id']) || empty($_GET['show_id'])) {
        die("Invalid request!. Show ID is required to select audience type.");
    }
?>

    <!-- Display a drop down and a field to select the audience type -->
    <form action="select-seats-count.php" method="post" class="mb-3">
        <input type="hidden" name="showId" value="<?php echo $_GET['show_id']; ?>" />
        <select name="audienceType" class="form-select" aria-label="Default select" required>
            <option selected disabled>Select Audience Type</option>
            <?php foreach (audienceTypes as $key => $value): ?>
                <?php if ($key !== 'ADMIN') { ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                <?php } ?>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary mt-3 w-100">Next</button>
    </form>

<?php closeContainer(); ?>

<?php createFooter(); ?>