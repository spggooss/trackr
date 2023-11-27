<?php

namespace Tests\Browser;

use App\Models\User\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserLoginTest extends DuskTestCase
{
    /**
     * Login as user test.
     */
    public function testExample(): void
    {
        $user = User::where('email', 'user@gmail.com')->first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('login')
                ->type('email', $user->email)
                ->type('password', 'user123')
                ->press('INLOGGEN')
                ->assertPathIs('/')
                ->assertSee($user->name);
        });
    }
}
