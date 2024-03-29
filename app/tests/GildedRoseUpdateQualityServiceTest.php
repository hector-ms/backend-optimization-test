<?php

namespace Runroom\GildedRose\Tests;

use PHPUnit\Framework\TestCase;
use Runroom\GildedRose\Service\GildedRoseUpdateQualityService;
use Runroom\GildedRose\Entity\Item;

class GildedRoseTest extends TestCase
{
   /**
    * @test
    */
   public function itemsDegradeQuality() :void
   {
      $items = [new Item('', 1, 5)];

      $gilded_rose = new GildedRoseUpdateQualityService($items);
      $gilded_rose->update_quality();

      $this->assertEquals(4, $items[0]->quality);
   }

   /**
    * @test
    */
   public function itemsDegradeDoubleQualityOnceTheSellInDateHasPass() :void
   {
      $items = [new Item('', -1, 5)];

      $gilded_rose = new GildedRoseUpdateQualityService($items);
      $gilded_rose->update_quality();

      $this->assertEquals(3, $items[0]->quality);
   }

   /**
    * @test
    */
   public function itemsCannotHaveNegativeQuality() :void
   {
      $items = [new Item('', 0, 0)];

      $gilded_rose = new GildedRoseUpdateQualityService($items);
      $gilded_rose->update_quality();

      $this->assertEquals(0, $items[0]->quality);
   }

   /**
    * @test
    */
   public function agedBrieIncreasesQualityOverTime() :void
   {
      $items = [new Item('Aged Brie', 0, 5)];

      $gilded_rose = new GildedRoseUpdateQualityService($items);
      $gilded_rose->update_quality();

      $this->assertEquals(7, $items[0]->quality);
   }

   /**
    * @test
    */
   public function qualityCannotBeGreaterThan50() :void
   {
      $items = [new Item('Aged Brie', 0, 50)];

      $gilded_rose = new GildedRoseUpdateQualityService($items);
      $gilded_rose->update_quality();

      $this->assertEquals(50, $items[0]->quality);
   }

   /**
    * @test
    */
   public function sulfurasDoesNotChange() :void
   {
      $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 10)];

      $gilded_rose = new GildedRoseUpdateQualityService($items);
      $gilded_rose->update_quality();

      $this->assertEquals(10, $items[0]->sell_in);
      $this->assertEquals(10, $items[0]->quality);
   }

   /**
    * @return array[]
    */
   public static function backstageRules() :array
   {
      return [
         'incr. 1 if sellIn > 10' => [11, 10, 11],
         'incr. 2 if 5 < sellIn <= 10 (max)' => [10, 10, 12],
         'incr. 2 if 5 < sellIn <= 10 (min)' => [6, 10, 12],
         'incr. 3 if 0 < sellIn <= 5 (max)' => [5, 10, 13],
         'incr. 3 if 0 < sellIn <= 5 (min)' => [1, 10, 13],
         'puts to 0 if sellIn <= 0 (max)' => [0, 10, 0],
         'puts to 0 if sellIn <= 0 (...)' => [-1, 10, 0],
      ];
   }

   /**
    * @dataProvider backstageRules
    * @test
    * @param mixed $sellIn
    * @param mixed $quality
    * @param mixed $expected
    * 
    * @return void
    */
   public function backstageQualityIncreaseOverTimeWithCertainRules($sellIn, $quality, $expected) :void
   {
      $items = [new Item('Backstage passes to a TAFKAL80ETC concert', $sellIn, $quality)];

      $gilded_rose = new GildedRoseUpdateQualityService($items);
      $gilded_rose->update_quality();

      $this->assertEquals($expected, $items[0]->quality);
   }
}
