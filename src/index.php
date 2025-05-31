<?php
    include('site.Master.php'); // Including the site master page.
    createProperties($filePathPrefix = "", $pageTitle = "Home");
    createHeader($menu = true); // Creating the header.
?>

<?php createContainer(); ?>

<p>ABC</p>

<?php closeContainer(); ?>

<?php createFooter(); ?>