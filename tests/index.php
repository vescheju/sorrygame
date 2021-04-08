<?php
require "/user/cse477/classweb/student/student.inc.php";
$view = new Testing\IndexView(__DIR__, $_GET);
echo $view->present();
