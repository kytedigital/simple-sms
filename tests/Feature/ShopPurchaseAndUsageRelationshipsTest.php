<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Shop;

class ShopPurchaseAndUsageRelationshipsTest extends TestCase
{
    /**
     *
     */
    public function testDataBaseContents()
    {
        $this->assertDatabaseHas('purchases', [
            'shop' => 'sms-dervelopment-2',
            'type' => 'credits',
            'quantity' => 100,
            'cost' => 5,
        ]);

        $this->assertDatabaseHas('usages', [
            'shop' => 'sms-dervelopment-2',
            'purchase_id' => '1',
            'type' => 'credits',
            'quantity' => 30,
        ]);
    }

    /**
     * Test Shop to Purchase relationships.
     */
    public function testShopToPurchaseRelationShips()
    {
        $purchases = Shop::where('name', static::SHOP_NAME)->first()->purchases();

        $this->assertEquals(1, $purchases->get()->count());

        $this->assertEquals('Message Credits', $purchases->first()->title);

        $this->assertEquals('sms-dervelopment-2', $purchases->first()->shop()->first()->name);
    }
}
