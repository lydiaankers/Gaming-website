<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    // Page-Specific Static Content
    if (isset($_SESSION["myuser"])) {
        $tusers = $_SESSION["myuser"];
        $twelcome = "";
        $twelcome = "Welcome $tusers";
    } else {
        $twelcome = "Welcome";
    }

    // Content Classes via XML and JSON
    $tarticles = xmlLoadAll("data/xml/articles-index.xml", "PLHomeArticle", "Article");

    // Get the News Item Array
    $tnilist = jsonLoadAllNewsItems();

    // Create the News Items for Article 2.
    $tnews = "";

    foreach ($tnilist as $tni) {
        $tnews = renderNewsItemAsList($tni);
    }

    $tgames = ! empty("data/html/threegames.html") ? file_get_contents("data/html/threegames.html") : "There are no details on this game.";

    // Build the Articles
    $tarticlehtml = "";
    foreach ($tarticles as $ta) {
        $tarticlehtml .= renderUIHomeArticle($ta);
    }

    $tcontent = <<<PAGE
            <div class="row">
                
             <div>
               <h2> {$twelcome} </h2>
                </div>
            <div class="well">
                    <ul class="list-group">
                    <li class="list-group-item">
                        {$tgames}
                    </ul>
                </div>
    		</div>
    		</div>
            <div class="row details">
            {$tarticlehtml}
            
            </div>
    PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

// Build up our Dynamic Content Items.
$tpagetitle = "Home Page";
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