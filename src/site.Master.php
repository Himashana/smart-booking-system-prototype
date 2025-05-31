<?php
    $GLOBALS['filePathPrefix'] = "";
    $GLOBALS['pageTitle'] = "";

    function createProperties($filePathPrefix, $pageTitle = ""){ // i.e.: ../ and ./ etc...
        $GLOBALS['filePathPrefix'] = $filePathPrefix;
        $GLOBALS['pageTitle'] = $pageTitle;
    }
?>

<?php function createHeader($menu = true){ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?php echo $GLOBALS['filePathPrefix']; ?>modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title><?php echo $GLOBALS['pageTitle']; ?> - Smart Booking</title>
</head>
<body>
    <?php if($menu){ ?>
        <nav id="navbar" class="navbar sticky-top navbar-expand-lg" style="background-color:white; color:#B58323; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);" data-bs-theme="light">
            <div class="container-fluid custom-container">
                <a class="navbar-brand" href="<?php echo $GLOBALS['filePathPrefix']; ?>" style="display: flex; align-items: center;">
                    <span style="display: inline-block; vertical-align: middle; margin-left: 10px; line-height: 1; color:#6E5A35;">Smart Booking</span>
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" style="color:#6E5A35;" aria-current="page" href="<?php echo $GLOBALS['filePathPrefix']; ?>#">ABC</a></li>
                        <li class="nav-item"><a class="nav-link active" style="color:#6E5A35;" aria-current="page" href="<?php echo $GLOBALS['filePathPrefix']; ?>#">DEF</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    <?php } ?>

<?php } ?>


<?php 
    function createContainer(){
        echo '<div class="container">';
    }

    function closeContainer(){
        echo '</div>';
    }
?>


<?php function createFooter(){ ?>
    <footer>

    </footer>

        <!-- Javascripts -->
        <script src="<?php echo $GLOBALS['filePathPrefix']; ?>modules/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
<?php } ?>