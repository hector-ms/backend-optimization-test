<?php

namespace Runroom\GildedRose\Service;

use Runroom\GildedRose\Entity\Item;

class GildedRoseUpdateQualityService
{

    /**
     * @var Item[]
     */
    private array $items;

    /**
     * @param Items[] $items
     */
    function __construct(array $items)
    {
        $this->items = $items;
    }

    function update_quality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality > 0 && $item->name != 'Sulfuras, Hand of Ragnaros') {
                    $item->quality = $item->quality - 1;
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                    if ($item->name == 'Backstage passes to a TAFKAL80ETC concert' && $item->sell_in < 11) {
                        $item->quality = $item->quality + 1;
                        if ($item->sell_in < 6) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                }
            }

            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $item->sell_in = $item->sell_in - 1;
            }

            if ($item->sell_in < 0) {
                if ($item->name != 'Aged Brie') {
                    if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->quality > 0 && $item->name != 'Sulfuras, Hand of Ragnaros') {
                            $item->quality = $item->quality - 1;
                        }
                    } else {
                        $item->quality = $item->quality - $item->quality;
                    }
                } else {
                    if ($item->quality < 50) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }
        }
    }
}
