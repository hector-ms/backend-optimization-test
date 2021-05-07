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
     * @param Item[] $items
     */
    function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return void
     */
    function update_quality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name !== 'Aged Brie' and $item->name !== 'Backstage passes to a TAFKAL80ETC concert') {
                $this->sub_quality($item);
            } else {
                $this->add_quality($item);
                $item->sell_in--;
            }

            if ($item->sell_in < 0) {
                if ($item->name !== 'Aged Brie') {
                    $this->sub_quality($item);
                } else {
                    $this->add_quality($item);
                }
            }
        }
    }

    /**
     * @param Item $item
     * 
     * @return void
     */
    private function sub_quality(Item $item): void
    {
        if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
            $item->quality = 0;
        } else if ($item->quality > 0 && $item->name !== 'Sulfuras, Hand of Ragnaros') {
            $item->quality--;
        }
    }

    /**
     * @param Item $item
     * 
     * @return void
     */
    private function add_quality(Item $item): void
    {
        if ($item->quality < 50) {
            $item->quality++;
            if ($item->name === 'Backstage passes to a TAFKAL80ETC concert' && $item->sell_in < 11) {
                $item->quality++;
                if ($item->sell_in < 6) {
                    $item->quality++;
                }
            }
        }
    }
}
