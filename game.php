<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($pgame)
{
    $tgameprofile = "";
    foreach ($pgame as $tp) {
        $tgameprofile .= renderGameOverview($tp);
    }

    // $ttabs = xmlLoadAll("data/xml/games.xml", "PLTab", "Tab");
    // $ttabhtml = renderUITabs($ttabs, "games-content");

    $tcontent = <<<PAGE
            {$tgameprofile}
    PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$tgame = [];
$tname = $_REQUEST["name"] ?? "";
$tsscore = $_REQUEST["score"] ?? - 1;
$tid = $_REQUEST["id"] ?? - 1;

// Handle our Requests and Search for Players using different methods
if (is_numeric($tid) && $tid > 0) {
    $tgame[] = jsonLoadOneGame($tid);
} else if (! empty($tname)) {
    // Filter the name
    $tname = appFormProcessData($tname);
    $tgamelist = jsonLoadAllGame();
} else if ($tsscore > 0) {
    $tgamelist = jsonLoadAllGame();
    foreach ($tgamelist as $tp) {
        if ($tp->score === $tsscore) {
            $tgame[] = $tp;
            break;
        }
    }
}

// Page Decision Logic - Have we found a player?
// Doesn't matter the route of finding them
if (count($tgame) === 0) {
    appGoToError();
} else {
    // We've found our player
    $tpagecontent = createPage($tgame);
    $tpagetitle = "Game Page";

    // ----BUILD OUR HTML PAGE----------------------------
    // Create an instance of our Page class
    $tpage = new MasterPage($tpagetitle);
    $tpage->setDynamic2($tpagecontent);
    $tpage->renderPage();
}
?>