<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    // Get the Data we need for this page
    $tgame = jsonLoadAllGame();

    usort($tgame, function ($a, $b) {
        return strcmp($a->score, $b->score);
    });
    $tgame = array_reverse($tgame);

    // $tkits = jsonLoadAllKit();

    // Build the UI Components
    $tgamehtml = renderGameTable($tgame);
    // $tkitshtml = renderKitTable($tkits);

    // Build UI Components with External HTML Loading

    // Construct the Page
    $tcontent = <<<PAGE
        <div class="media-body">
                <div class="well">
                    <h1>Ranking Page</h1>
                </div>
             <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Game Review Ranks</h3>
            </div>
            <div class="panel-body">
             {$tgamehtml}
            </div>
        </div>
         
    PAGE;

    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

// Build up our Dynamic Content Items.
$tpagetitle = "Ranking Information";
$tpagelead = "";
$tpagecontent = createPage();
$tpagefooter = "";

// ----BUILD OUR HTML PAGE----------------------------
// Create an instance of our Page class
$tpage = new MasterPage($tpagetitle);
// Set the Three Dynamic Areas (1 and 3 have defaults)
if (! empty($tpagelead))
    $tpage->setDynamic1($tpagelead);
$tpage->setDynamic2($tpagecontent);
if (! empty($tpagefooter))
    $tpage->setDynamic3($tpagefooter);
// Return the Dynamic Page to the user.
$tpage->renderPage();
?>