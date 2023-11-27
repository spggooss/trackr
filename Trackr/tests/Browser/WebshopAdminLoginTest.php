<?php

namespace Tests\Browser;

use App\Models\User\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WebshopAdminLoginTest extends DuskTestCase
{
    /**
     * Login as webshop admin test.
     */
    public function testExample(): void
    {
        $webshopAdmin = User::where('email', 'admin@bol.com')->first();
        $this->browse(function (Browser $browser) use ($webshopAdmin) {
            $browser->visitRoute('login')
                ->type('email', $webshopAdmin->email)
                ->type('password', 'bolcom')
                ->press('INLOGGEN')
                ->assertPathIs('/')
                ->assertSee($webshopAdmin->name);
        });
    }
}
