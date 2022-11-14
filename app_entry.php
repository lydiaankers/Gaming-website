<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$tmyname = $_REQUEST["myname"] ?? "";
if (! empty($tmyname)) {
    $tmyname = $_REQUEST["myname"];
    $_SESSION["myuser"] = $tmyname;
    $_SESSION["entered"] = true;
    appGoToHome();
} else {
    appGoToError();
}

?>