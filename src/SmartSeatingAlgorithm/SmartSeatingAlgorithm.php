<!-- Disable accessing normally through the web browser -->
<?php
   if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
       die("Access denied.");
   }

    require_once __DIR__ . '/types.php';
?>

<?php
   class SmartSeatingAlgorithm {
        public static function predictSeats(
            $gridMatrix,
            $audienceType,
            $theatreSection,
            $audienceCount,
        ){
            return;
        }
   }
?>