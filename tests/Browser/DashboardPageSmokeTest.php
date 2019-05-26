<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\DashboardPage;

class DashboardPageSmokeTest extends DuskTestCase
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
            $browser->visit(new DashboardPage)
                    ->assertPresent('@layout');
        });
    }
}
