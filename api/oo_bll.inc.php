<?php

class BLLNewsItem
{

    // -------CLASS FIELDS------------------
    public $id = null;

    public $heading;

    public $tagline;

    public $thumb_href;

    public $storyimg_href;

    public $item_href;

    public $summary;

    public $content;

    public function fromArray(stdClass $passoc)
    {
        foreach ($passoc as $tkey => $tvalue) {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLConsole
{

    // -------CLASS FIELDS------------------
    public $id = null;

    public $name;

    public $cpu;

    public $gpu;

    public $ram;

    public $storage;

    public $size;

    public $releasedate;

    public $desc;

    public $consoledif;

    public $gif;

    public function fromArray(stdClass $passoc)
    {
        foreach ($passoc as $tkey => $tvalue) {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLGame
{

    // -------CLASS FIELDS------------------
    public $id = null;

    public $name;

    public $desc;

    public $review;

    public $tags;

    public $releasedate;

    public $developer;

    public $publisher;

    public $rating;

    public $extrev;

    public $score;

    public $retailer;

    public function fromArray(stdClass $passoc)
    {
        foreach ($passoc as $tkey => $tvalue) {
            $this->{$tkey} = $tvalue;
        }
    }
}

?>