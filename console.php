<?php
// ----INCLUDE APIS------------------------------------
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    // Get the Data we need for this page
    $tconsole = jsonLoadOneConsole(1);
    // $tcitems = xmlLoadAll("data/img/carousel-club.xml","PLCarouselImage","Image");

    // Build the UI Components
    $tconsolehtml = renderConsoleSummary($tconsole);
    // $tcarouselhtml = renderUICarousel($tcitems,"img/carousel");

    // Build UI Components with External HTML Loading fix thisssssss

    // Construct the Page
    $tcontent = <<<PAGE
         {$tconsolehtml}
           
    
         
    PAGE;

    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

// Build up our Dynamic Content Items.
$tpagetitle = "Console Overview";
$tpagelead = "Play Station 5 Overview";
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