<?php

namespace Runroom\GildedRose\Service;

use Runroom\GildedRose\Entity\Item;

class GildedRoseUpdateQualityService
{
    const AGED_BRIE_NAME = 'Aged Brie';
    const BACKSTAGE_TAFKAL80ETC_CONCERT_NAME = 'Backstage passes to a TAFKAL80ETC concert';
    const SULFURAS_HAND_RAGNAROS_NAME = 'Sulfuras, Hand of Ragnaros';

    const MAX_QUALITY_EDITABLE = 50;
    const LOW_SELL_IN = 11;
    const VERY_LOW_SELL_IN = 6;

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
            if ($item->name !== self::AGED_BRIE_NAME && $item->name !== self::BACKSTAGE_TAFKAL80ETC_CONCERT_NAME) {
                $this->sub_quality($item);
            } else {
                $this->add_quality($item);
                $item->sell_in--;
            }

            if ($item->sell_in < 0) {
                if ($item->name === self::AGED_BRIE_NAME) {
                    $this->add_quality($item);
                } else {
                    $this->sub_quality($item);
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
        if ($item->name === self::BACKSTAGE_TAFKAL80ETC_CONCERT_NAME) {
            $item->quality = 0;
        } else if ($item->quality > 0 && $item->name !== self::SULFURAS_HAND_RAGNAROS_NAME) {
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
        if ($item->quality < self::MAX_QUALITY_EDITABLE) {
            $item->quality++;
            if ($item->name === self::BACKSTAGE_TAFKAL80ETC_CONCERT_NAME && $item->sell_in < self::LOW_SELL_IN) {
                $item->quality++;
                if ($item->sell_in < self::VERY_LOW_SELL_IN) {
                    $item->quality++;
                }
            }
        }
    }
}
