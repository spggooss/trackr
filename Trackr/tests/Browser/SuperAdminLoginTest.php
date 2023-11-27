<?php

namespace Tests\Browser;

use App\Models\User\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SuperAdminLoginTest extends DuskTestCase
{
    /**
     * Login as superadmin test.
     */
    public function testExample(): void
    {
        $superAdmin = User::where('email', 'superadmin@trackr.nl')->first();
        $this->browse(function (Browser $browser) use ($superAdmin) {
            $browser->visitRoute('login')
                ->type('email', $superAdmin->email)
                ->type('password', 'superadmin123')
                ->press('INLOGGEN')
                ->assertPathIs('/')
                ->assertSee($superAdmin->name);
        });
    }
}
