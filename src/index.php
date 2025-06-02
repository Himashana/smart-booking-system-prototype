<?php
    include('site.Master.php'); // Including the site master page.
    createProperties($filePathPrefix = "", $pageTitle = "Home");
    createHeader($menu = true); // Creating the header.
?>

<?php createContainer(); ?>

<?php
    include('./Show.php');
    
    $show = new Show();

    // Get all shows
    $shows = $show->getAllShows();
    
    if ($shows) {
        echo "<h2>All Shows</h2>";
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
        foreach ($shows as $s) {
            ?>
                <a href="./select-audience.php?show_id=<?php echo htmlspecialchars($s['id']); ?>" style="text-decoration: none;">
                    <div class="col">
                        <div class="card">
                        <img src="./img/background-4326353_640.jpg" class="card-img-top" alt="...">
                        <div class="card-body" style="min-height: 110px;">
                            <h5 class="card-title"><?php echo htmlspecialchars($s['movie_title']); ?></h5>
                            <p class="card-text">On <?php echo htmlspecialchars($s['showtime']); ?></p>
                        </div>
                        </div>
                    </div>
                </a>
            <?php
            // echo "<li>" . htmlspecialchars($s['movie_title']) . " at " . htmlspecialchars($s['showtime']) . "</li>";
        }
        echo "</div>";
    } else {
        echo "<p>No shows available.</p>";
    }
?>

<?php closeContainer(); ?>

<?php createFooter(); ?>