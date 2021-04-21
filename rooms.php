<?php
require __DIR__ . '/lib/game.inc.php';
$open = true;
$view = new Game\RoomsView($site);
if(!$view->protect($site, $user)) {
    header("location: " . $view->getProtectRedirect());
    exit;
}
?>
<!doctype html>
<html>
<head>
    <?php echo $view->head(); ?>
</head>
<body>
<?php echo $view->header(); ?>
<?php echo $view->present(); ?>
<?php echo $view->footer(); ?>
</body>

</html>