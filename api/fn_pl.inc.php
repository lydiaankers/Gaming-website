<?php
require_once ("oo_bll.inc.php");
require_once ("oo_pl.inc.php");

// ===========RENDER BUSINESS LOGIC OBJECTS=======================================================================

// ----------NEWS ITEM RENDERING------------------------------------------
function renderNewsItemAsList(BLLNewsItem $pitem)
{
    $tnewsitem = <<<NI
    		    <section class="list-group-item clearfix">
    		        <div class="media-left media-top">
                        <img src="img/news/{$pitem->thumb_href}" height=200 width="100" />
                    </div>
                    <div class="media-body">
    				<h4 class="list-group-item-heading">{$pitem->heading}</h4>
    				<p class="list-group-item-text">{$pitem->tagline}</p>
    				<a class="btn btn-xs btn-default" href="news.php?storyid={$pitem->id}">Read...</a>
    				</div>
    			</section>
    NI;
    return $tnewsitem;
}

function renderNewsItemAsSummary(BLLNewsItem $pitem)
{
    $titemsrc = ! empty($pitem->thumb_href) ? $pitem->thumb_href : "blank-thumb.jpg";
    $tnewsitem = <<<NI
    		    <section class="row details clearfix">
    		    <div class="media-left media-top">
    				<img src="img/news/{$titemsrc}" width=256 />
    			</div>
    			<div class="media-body">
    				<h2>{$pitem->heading}</h2>
    				<div class="ni-summary">
    				<p>{$pitem->summary}</p>
    				</div>
    				<a class="btn btn-xs btn-default" href="news.php?storyid={$pitem->id}">Get the Full Story</a>
    	        </div>
    			</section>
    NI;
    return $tnewsitem;
}

function renderNewsItemFull(BLLNewsItem $pitem)
{
    $titemsrc = ! empty($pitem->img_href) ? $pitem->img_href : "blank-thumb.jpg";
    $tnewsitem = <<<NI
    		    <section class="row details">
    		        <div class="well">
    		        <div class="media-left">
    				    <img src="img/news/{$titemsrc}" />
    				</div>
    				<div class="media-body">
    				    <h1>{$pitem->heading}</h1>
    				    <p id="news-tag">{$pitem->tagline}</p>
    				    <p id="news-summ">{$pitem->summary}</p>
    				    <p id="news-main">{$pitem->content}</p>
    				</div>
    				</div>
    			</section>
    NI;
    return $tnewsitem;
}

// ----------COACH RENDERING----------------------------------------------
function renderGameTable(array $pgamelist)
{
    $trowdata = "";
    foreach ($pgamelist as $tc) {
        $tlink = "<a class=\"btn btn-info\" href=\"game.php?type=game&id={$tc->id}\">More...</a>";
        $trowdata .= "<tr><td>{$tc->name}</td><td>{$tc->score}</td><td>{$tlink}</td></tr>";
    }
    $ttable = <<<TABLE
    <table class="table table-striped table-hover">
    	<thead>
    		<tr>
    	       	<th>Game Name</th>
    			<th>score</th>
    			<th>Link</th>
    		</tr>
    	</thead>
    	<tbody>
    	   {$trowdata}
    	</tbody>
    </table>
    TABLE;
    return $ttable;
}

// ----------CONSOLE RENDERING--------------------------------------------
function renderConsoleSummary(BLLConsole $ps)
{
    $tbioref = ! empty($ps->desc) ? file_get_contents("data/html/{$ps->desc}") : "There are no details on this game.";
    $tbio = $tbioref;
    $tdif = ! empty($ps->consoledif) ? file_get_contents("data/html/{$ps->consoledif}") : "There are no details on this game.";
    $timgref = "img/console/{$ps->img}.jpg";
    $timg = $timgref;
    $tgif = "img/console/{$ps->gif}.gif";
    $tgifref = $tgif;
    $tshtml = <<<OVERVIEW
        <article class="row marketing">
            <h1><b>Console Overview</bold></h1>
            <div class="media-left">
                <img src="$timg" width="300" />
            </div>
            <div class="media-body">
                <div class="well">
                    <h1>{$ps->name}</h1>
                </div>
                <h4>{$tbio}</h4>
                <div class="media-left">
                <div class="panel-heading">
                <iframe width="853" height="480" src="https://www.youtube.com/embed/RkC0l4iekYo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div> </div>
            </div>
            <div class="panel-heading">
                <h3 class="panel-title"> Console Specs: </h3>
            </div>
            <div class="well">
                <ul class="list-group">
                    <li class="list-group-item">
                        CPU: <strong>{$ps->cpu}</strong>
                    </li>
                    <li class="list-group-item">
                        GPU: <strong>{$ps->gpu}</strong>
                    </li>
                    <li class="list-group-item">
                        RAM: <strong>{$ps->ram}</strong>
                    </li>
                    <li class="list-group-item">
                       Storage: <strong>{$ps->storage}</strong>
                    </li>
                    <li class="list-group-item">
                       Dimentions: <strong>{$ps->size}</strong>
                    </li>
                    <li class="list-group-item">
                       Release Date: <strong>{$ps->releasedate}</strong>
                    </li>
                </div>
                
                 <div class="media-left">
                    <div class="panel-heading">
                    <img src="$tgifref" width="800" />
                    </div>
                    </div>
                    <div class="well">
                    <h4>{$tdif}</h4>
                    </div>
                </div>
                </ul>
             </div>
        </article>
    OVERVIEW;
    return $tshtml;
}

// ----------GAME RENDERING---------------------------------------
function renderGameOverview(BLLGame $pp)
{
    $tbio = ! empty($pp->bio) ? file_get_contents("data/html/games/{$pp->bio}") : "There are no details on this game.";
    $tretailer = ! empty($pp->retailer) ? file_get_contents("data/html/retailers/{$pp->retailer}") : "There are no details on this game.";
    $textrev = ! empty($pp->extrev) ? file_get_contents("data/html/extrevs/{$pp->extrev}.html") : "There are no details on this game.";
    $trev = ! empty($pp->review) ? file_get_contents("data/html/games/{$pp->review}") : "There are no details on this game.";

    $timgref = "img/games/{$pp->name}.jpg";
    $timg = $timgref;
    $toverview = <<<OV
        <article class="row marketing">
            <h1><b>Game Review</bold></h1>
            <div class="media-left">
                <div class="media-body">
                    <div class="well">
                    <h1>{$pp->name}</h1>
                </div>
                <img src="$timg" height = 400 width="350" />
                <span class="badge"> <h2>Score: {$pp->score}</h2> </span>
            </div>
            <div class="panel-heading">
                <h3 class="panel-title">Game Description: </h3>
            </div>
               <div class="panel" <h4>{$tbio}</h4> 
            </div>
                <div class="panel-heading">
                    <h3 class="panel-title">My Review: </h3>
            </div>
             <div class="panel" <h4>{$trev}</h4> </div>
            
             <div class="panel-heading">
                <h3 class="panel-title">Game Overview: </h3>
            </div>
            <div class="well">
                <ul class="list-group">
                    <li class="list-group-item">
                        Tags: <strong>{$pp->tags}</strong>
                    </li>
                    <li class="list-group-item">
                        Release Date: <strong>{$pp->releasedate}</strong>
                    </li>
                    <li class="list-group-item">
                        Developer: <strong>{$pp->developer}</strong>
                    </li>
                    <li class="list-group-item">
                        Publisher: <strong>{$pp->publisher}</strong>
                    </li>
                    <li class="list-group-item">
                       Rating: <strong>{$pp->rating}</strong>
                    </li>
                </ul>
             </div>
            </div>
            <div class="panel-heading">
                <h3 class="panel-title">External Reviews: </h3>
            </div>
                <div class="well">
                    <ul class="list-group">
                    <li class="list-group-item">
                        {$textrev}
                    </ul>
                </div>  
               <div class="panel-heading">
                <h3 class="panel-title">External Reviews: </h3>
            </div>
                <div class="well">
                    <ul class="list-group">
                    <li class="list-group-item">
                        {$tretailer}
                    </ul>
                </div>  
                </div>
        </article>
    OV;
    return $toverview;
}

// =============RENDER PRESENTATION LOGIC OBJECTS==================================================================
function renderUICarousel(array $pimgs, $pimgdir, $pid = "mycarousel")
{
    $tci = "";
    $count = 0;

    // -------Build the Images---------------------------------------------------------
    foreach ($pimgs as $titem) {
        $tactive = $count === 0 ? " active" : "";
        $thtml = <<<ITEM
                <div class="item{$tactive}">
                    <img class="img-responsive" src="{$pimgdir}/{$titem->img_href}">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>{$titem->title}</h1>
                            <p class="lead">{$titem->lead}</p>
        		        </div>
        			</div>
        	    </div>
        ITEM;
        $tci .= $thtml;
        $count ++;
    }

    // --Build Navigation-------------------------
    $tdot = "";
    $tdotset = "";
    $tarrows = "";

    if ($count > 1) {
        for ($i = 0; $i < count($pimgs); $i ++) {
            if ($i === 0)
                $tdot .= "<li data-target=\"#{$pid}\" data-slide-to=\"$i\" class=\"active\"></li>";
            else
                $tdot .= "<li data-target=\"#{$pid}\" data-slide-to=\"$i\"></li>";
        }
        $tdotset = <<<INDICATOR
                <ol class="carousel-indicators">
                {$tdot}
                </ol>
        INDICATOR;
    }
    if ($count > 1) {
        $tarrows = <<<ARROWS
        		<a class="left carousel-control" href="#{$pid}" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
        		<a class="right carousel-control" href="#{$pid}" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
        ARROWS;
    }

    $tcarousel = <<<CAROUSEL
        <div class="carousel slide" id="{$pid}">
                {$tdotset}
    			<div class="carousel-inner">
    				{$tci}
    			</div>
    		    {$tarrows}
        </div>
    CAROUSEL;
    return $tcarousel;
}

function renderUITabs(array $ptabs, $ptabid)
{
    $count = 0;
    $ttabnav = "";
    $ttabcontent = "";

    foreach ($ptabs as $ttab) {
        $tnavactive = "";
        $ttabactive = "";
        if ($count === 0) {
            $tnavactive = " class=\"active\"";
            $ttabactive = " active in";
        }
        $ttabnav .= "<li{$tnavactive}><a href=\"#{$ttab->tabid}\" data-toggle=\"tab\">{$ttab->tabname}</a></li>";
        $ttabcontent .= "<article class=\"tab-pane fade{$ttabactive}\" id=\"{$ttab->tabid}\">{$ttab->content}</article>";
        $count ++;
    }

    $ttabhtml = <<<HTML
            <ul class="nav nav-tabs">
            {$ttabnav}
            </ul>
        	<div class="tab-content" id="{$ptabid}">
    			  {$ttabcontent}
    		</div>
    HTML;
    return $ttabhtml;
}

function renderUIHomeArticle(PLHomeArticle $phome, $pwidth = 4)
{
    // $timg = file_get_contents("img/news/{$phome->storyimg_href}");
    $timgref = "img/{$phome->storyimg_href}";
    $thome = <<<HOME
    
        <article class="col-lg-{$pwidth}">
    		<h2>{$phome->heading}</h2>
    		<h4>
    			<span class="label label-success">{$phome->tagline}</span>
    		</h4>
    		<div class="home-thumb">
    			<img src= {$timgref} height=200 />
    		</div>
    		<div>
             <div class="panel">
    		  <strong>
    			{$phome->summary}
    		  </strong>
    		    {$phome->content}
            </div>
            <div class="options details">
    			<a class="btn btn-info" href="{$phome->link}">{$phome->linktitle}</a>
            </div>
    	</article>
    HOME;
    return $thome;
}

function renderUIKeyGamesList(array $pkeygames)
{
    $tkeylist = "";
    foreach ($pkeygames as $tkey) {
        $tli = <<<LI
                <section class="list-group-item">
                    <h4 class="list-group-item-heading">
                        <a href="game.php?name={$tkey->key_href}">{$tkey->name}</a>
                    </h4>
                    <p class="list-group-item-text">{$tkey->desc}</p>
                </section>
        LI;
        $tkeylist .= $tli;
    }

    $tpanel = <<<PANEL
        <div class="panel panel-default">
            <div class="panel-heading">Key Games</div>
            <div class="panel-body">
            <div class="list-group">
            {$tkeylist}
            </div>
    PANEL;
    return $tpanel;
}

function renderUIStatistics(array $pstats)
{
    $tstats = "";
    foreach ($pstats as $tstat) {
        $tstats .= <<<STAT
                <li class="list-group-item">
                    <span class="badge">{$tstat->value}</span>
                    <strong>{$tstat->stat}: </strong>
                    <a href="player.php?name={$tstat->ref}">{$tstat->holder}</a>
                </li>
        STAT;
    }

    $tpanel = <<<PANEL
        <div class="well well-lg">
            <ul class="list-group">
                {$tstats}
            </ul>
        </div>
    PANEL;
    return $tpanel;
}

function renderPagination($ppage, $pno, $pcurr)
{
    if ($pno <= 1)
        return "";

    $titems = "";
    $tld = $pcurr == 1 ? " class=\"disabled\"" : "";
    $trd = $pcurr == $pno ? " class=\"disabled\"" : "";

    $tprev = $pcurr - 1;
    $tnext = $pcurr + 1;

    $titems .= "<li$tld><a href=\"{$ppage}?page={$tprev}\">&laquo;</a></li>";
    for ($i = 1; $i <= $pno; $i ++) {
        $ta = $pcurr == $i ? " class=\"active\"" : "";
        $titems .= "<li$ta><a href=\"{$ppage}?page={$i}\">{$i}</a></li>";
    }
    $titems .= "<li$trd><a href=\"${ppage}?page={$tnext}\">&raquo;</a></li>";

    $tmarkup = <<<NAV
        <ul class="pagination pagination-sm">
            {$titems}
        </ul>
    NAV;
    return $tmarkup;
}

function renderUIGoogleMap($plong, $plat)
{
    $tmaphtml = <<<MAP
        <iframe width="100%" height="100%"
                            frameborder="1" scrolling="no" marginheight="0"
                            marginwidth="0"
                            src="http://maps.google.com/maps?f=q&amp;
                            source=s_q&amp;hl=en&amp;
                            geocode=&amp;q={$plong},{$plat}
                            &amp;output=embed"></iframe>
    MAP;
    return $tmaphtml;
}

?>