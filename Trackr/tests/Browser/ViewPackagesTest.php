<?php

namespace Tests\Browser;

use App\Models\User\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewPackagesTest extends DuskTestCase
{


    /**
     * Login as user test.
     */
    public function testExample(): void
    {
        $webshopAdmin = User::where('email', 'admin@bol.com')->first();
        $this->browse(function (Browser $browser) use ($webshopAdmin) {
            $browser->visitRoute('login')
                ->type('email', $webshopAdmin->email)
                ->type('password', 'bolcom')
                ->press('INLOGGEN')
                ->assertPathIs('/');
        });

        $this->browse(function (Browser $browser) use ($webshopAdmin) {
            $browser->visitRoute('admin.packages.webshop.index', ['webshop' => 1])
                ->assertPathIs('/admin/packages/webshop/1');
        });
    }
}
