<?php
    include('site.Master.php'); // Including the site master page.
    createProperties($filePathPrefix = "./", $pageTitle = "Admin Login");
    createHeader($menu = true); // Creating the header.
?>

<?php createContainer(); ?>

<?php
    // Check if the user is already logged in
    session_start();
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        header("Location: index.php");
        exit();
    }
?>

<center>
    <div style="border: 1px solid #ccc; background-color:#f7f7f7; padding: 20px; width: 40%; margin-top: 20px;">
        <h2>Login to your account</h2>
        <form action="" method="post" class="mt-3">
            <input type="text" class="form-control mb-2" id="username" name="username" placeholder="Username" required>
            <input type="password" class="form-control mb-2" id="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-primary mt-2" style="width: 100%;">Login</button>
        
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    // Dummy credentials for demonstration purposes
                    $adminUsername = "admin";
                    $adminPassword = "1234";

                    if ($username === $adminUsername && $password === $adminPassword) {
                        // Create a session variable to indicate the user is logged in
                        session_start();
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['username'] = $username;
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger mt-3'>Invalid username or password.</div>";
                    }
                }
            ?>
        </form>
    </div>
</center>


<?php closeContainer(); ?>

<?php createFooter(); ?>