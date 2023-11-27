<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiLoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

    }

    protected function refreshDatabase()
    {
        // Run the database migrations
        Artisan::call('migrate:refresh');

        // Begin a database transaction
        DB::beginTransaction();
        Artisan::call('db:seed');
    }

    public function testApiLogin(): void
    {
        $loginData = [
            'email' => 'superadmin@trackr.nl',
            'password' => 'superadmin123',
        ];

        // Make an API call to the shipment notification endpoint
        $response = $this->post('/api/login', $loginData);

        $response->assertStatus(200);

    }

    protected function tearDown(): void
    {
        // Roll back the database transaction
        DB::rollBack();

        // Call the parent tearDown method
        parent::tearDown();
    }

}
