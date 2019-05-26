<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\RefreshPage;

class RefreshPageSmokeTest extends DuskTestCase
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
            $browser->visit(new RefreshPage)
                    ->assertSee('Please Reopen The App')
                    ->assertPresent('@banner');
        });
    }
}
