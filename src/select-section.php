<?php
    include('site.Master.php'); // Including the site master page.
    createProperties($filePathPrefix = "", $pageTitle = "Book a show");
    createHeader($menu = true); // Creating the header.
?>

<?php createContainer(); ?>

<?php require_once __DIR__ . '/SmartSeatingAlgorithm/types.php'; ?>

    <!-- Display a drop down and a field to select the audience type -->
    <form action="select-seats.php" method="post" class="mb-3">
        <input type="hidden" name="showId" value="<?php echo $_POST['showId']; ?>" />
        <input type="hidden" name="audienceType" value="<?php echo $_POST['audienceType'] ?? ''; ?>">
        <input type="hidden" name="audienceCount" value="<?php echo $_POST['audienceCount'] ?? 1; ?>">
        <select name="theatreSection" class="form-select" aria-label="Default select" required>
            <option selected disabled>Select a section of the theater</option>
            <?php foreach (theatreSections as $key => $value): ?>
                <?php if ($key !== 'ADMIN') { ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                <?php } ?>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary mt-3 w-100">Next</button>
    </form>

<?php closeContainer(); ?>

<?php createFooter(); ?>