<?php


namespace Tests\Unit;

use App\Business\Packages\CsvImporter;
use App\Models\Address\AddressRepository;
use App\Models\Package\PackagesRepository;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Mockery\MockInterface;
use Tests\TestCase;

class CsvImporterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected CsvImporter $csvImporter;
    protected PackagesRepository|MockInterface $packagesRepository;
    protected AddressRepository|MockInterface $addressRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->packagesRepository = $this->mock(PackagesRepository::class);
        $this->addressRepository = $this->mock(AddressRepository::class);

        $this->csvImporter = new CsvImporter($this->packagesRepository, $this->addressRepository);
    }

    protected function refreshDatabase()
    {
        // Run the database migrations
        Artisan::call('migrate:refresh');

        // Begin a database transaction
        DB::beginTransaction();
        Artisan::call('db:seed');
    }

    protected function tearDown(): void
    {
        // Roll back the database transaction
        DB::rollBack();

        // Call the parent tearDown method
        parent::tearDown();
    }

    public function testImportCsv()
    {

        $user = User::factory()->create(); // Assuming you have a User factory set up

        $user->webshop = null; // Set the webshop property to the desired value

        $this->actingAs($user);

        // Create a mock handle
        $handle = fopen( __DIR__ .'/files/testdata.csv', 'r');


        // Set expectations on the repositories
        $this->addressRepository->shouldReceive('store')->times(20);
        $this->packagesRepository->shouldReceive('store')->times(10);

        // Call the importCsv method
        $this->csvImporter->importCsv($handle);

    }
}


