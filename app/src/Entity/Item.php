<?php

namespace Runroom\GildedRose\Entity;

class Item
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var int
     */
    public int $sell_in;

    /**
     * @var int
     */
    public int $quality;

    /**
     * @param string $name
     * @param int $sell_in
     * @param int $quality
     */
    function __construct(string $name, int $sell_in, int $quality)
    {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    /**
     * @return string
     */
    public function __toString() :string
    {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }
}
