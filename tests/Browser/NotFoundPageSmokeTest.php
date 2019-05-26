<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\NotFoundPage;

class NotFoundPageSmokeTest extends DuskTestCase
{
    /**
     * A basic smoke test for the Dashboard
     *
     * @return void
     * @throws \Throwable
     */
    public function testDashboardLoads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new NotFoundPage())
                    ->assertSee('404')
                    ->assertPresent('@code')
                    ->assertPresent('@message');
        });
    }
}
