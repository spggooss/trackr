<?php

namespace Tests\Unit;

use App\Http\Controllers\Web\Packages\LabelController;
use App\Http\Controllers\Web\Packages\Requests\GenerateLabelRequest;
use App\Models\Address\Address;
use App\Models\Address\AddressRepository;
use App\Models\Package\Package;
use App\Models\Package\PackagesRepository;
use App\Models\Package\PackageStatus;
use Barryvdh\DomPDF\PDF as PDFFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Mockery;
use Smalot\PdfParser\Parser as PDFParser;
use Tests\TestCase;

class GenerateLabelsBulkTest extends TestCase
{
    use DatabaseTransactions;

    var Address $pickupAddress1;
    var Address $dropoffAddress1;
    var Package $package1;

    var Address $pickupAddress2;
    var Address $dropoffAddress2;
    var Package $package2;

    var Address $pickupAddress3;
    var Address $dropoffAddress3;
    var Package $package3;

    var string $directoryName = './tests/files';
    var string $fileName = 'labelCollection_unit_test.pdf';

    public function setUp(): void
    {
        parent::setUp();

        $addressRepo = Mockery::mock(AddressRepository::class);
        $pickupAddress1 = new Address([
            'street_name' => 'Fake Street 1',
            'house_number' => '123',
            'postal_code' => '1111AB',
            'city' => 'Fake City 1',
            'country' => 'Fake Country 1',
        ]);
        $dropoffAddress1 = new Address([
            'street_name' => 'Fake Street 1',
            'house_number' => '456',
            'postal_code' => '2222CD',
            'city' => 'Fake City 1',
            'country' => 'Fake Country 1',
        ]);
        $pickupAddress2 = new Address([
            'street_name' => 'Fake Street 2',
            'house_number' => '1234',
            'postal_code' => '3333EF',
            'city' => 'Fake City 2',
            'country' => 'Fake Country 2',
        ]);
        $dropoffAddress2 = new Address([
            'street_name' => 'Fake Street 2',
            'house_number' => '5678',
            'postal_code' => '4444GH',
            'city' => 'Fake City 2',
            'country' => 'Fake Country 2',
        ]);
        $pickupAddress3 = new Address([
            'street_name' => 'Fake Street 3',
            'house_number' => '12345',
            'postal_code' => '5555IJ',
            'city' => 'Fake City 3',
            'country' => 'Fake Country 3',
        ]);
        $dropoffAddress3 = new Address([
            'street_name' => 'Fake Street 3',
            'house_number' => '67890',
            'postal_code' => '6666KL',
            'city' => 'Fake City 3',
            'country' => 'Fake Country 3',
        ]);
        $addressRepo->shouldReceive('store')->andReturnUsing(function ($pickupAddress) {
            $pickupAddress->save();
            return $pickupAddress;
        });
        $addressRepo->shouldReceive('store')->andReturnUsing(function ($dropoffAddress) {
            $dropoffAddress->save();
            return $dropoffAddress;
        });
        $this->pickupAddress1 = $addressRepo->store($pickupAddress1);
        $this->dropoffAddress1 = $addressRepo->store($dropoffAddress1);
        $this->pickupAddress2 = $addressRepo->store($pickupAddress2);
        $this->dropoffAddress2 = $addressRepo->store($dropoffAddress2);
        $this->pickupAddress3 = $addressRepo->store($pickupAddress3);
        $this->dropoffAddress3 = $addressRepo->store($dropoffAddress3);

        $packageRepo = Mockery::mock(PackagesRepository::class);
        $package1 = new Package([
            'status' => PackageStatus::CREATE(PackageStatus::REGISTERED),
            'name' => 'Fake Name 1',
            'email' => 'fake1@email.com',
            'trace_code' => "TR" . Str::random(),
        ]);
        $package2 = new Package([
            'status' => PackageStatus::CREATE(PackageStatus::REGISTERED),
            'name' => 'Fake Name 2',
            'email' => 'fake2@email.com',
            'trace_code' => "TR" . Str::random(),
        ]);
        $package3 = new Package([
            'status' => PackageStatus::CREATE(PackageStatus::REGISTERED),
            'name' => 'Fake Name 3',
            'email' => 'fake3@email.com',
            'trace_code' => "TR" . Str::random(),
        ]);
        $packageRepo->shouldReceive('store')->andReturn($package1);
        $packageRepo->shouldReceive('store')->andReturn($package2);
        $packageRepo->shouldReceive('store')->andReturn($package3);
        $this->package1 = $packageRepo->store($package1);
        $this->package1->assignPickupAddress($this->pickupAddress1);
        $this->package1->assignDropOffAddress($this->dropoffAddress1);
        $this->package2 = $packageRepo->store($package2);
        $this->package2->assignPickupAddress($this->pickupAddress2);
        $this->package2->assignDropOffAddress($this->dropoffAddress2);
        $this->package3 = $packageRepo->store($package3);
        $this->package3->assignPickupAddress($this->pickupAddress3);
        $this->package3->assignDropOffAddress($this->dropoffAddress3);
    }

    /**
     * Test if a PDF is generated.
     * Test if the generated PDF for a label contains the correct information.
     */
    public function testGeneratedLabelPDF(): void
    {
        // Mock label request
        $generateLabelsRequest = Mockery::mock(GenerateLabelRequest::class);
        $generateLabelsRequest->shouldReceive('getPackageIds')->andReturn([$this->package1->id, $this->package2->id, $this->package3->id]);

        // Mock custom packages
        $package1 = Mockery::mock(Package::class);
        $package1->shouldReceive('getAttribute')->with('id')->andReturn($this->package1->id);
        $package1->shouldReceive('getAttribute')->with('pickup_address_id')->andReturn($this->pickupAddress1->id);
        $package1->shouldReceive('getAttribute')->with('dropoff_address_id')->andReturn($this->dropoffAddress1->id);
        $package1->shouldReceive('getAttribute')->with('trace_code')->andReturn($this->package1->trace_code);
        $package1->shouldReceive('getAttribute')->with('name')->andReturn($this->package1->name);
        $package1->shouldReceive('getAttribute')->with('email')->andReturn($this->package1->email);
        $package2 = Mockery::mock(Package::class);
        $package2->shouldReceive('getAttribute')->with('id')->andReturn($this->package2->id);
        $package2->shouldReceive('getAttribute')->with('pickup_address_id')->andReturn($this->pickupAddress2->id);
        $package2->shouldReceive('getAttribute')->with('dropoff_address_id')->andReturn($this->dropoffAddress2->id);
        $package2->shouldReceive('getAttribute')->with('trace_code')->andReturn($this->package2->trace_code);
        $package2->shouldReceive('getAttribute')->with('name')->andReturn($this->package2->name);
        $package2->shouldReceive('getAttribute')->with('email')->andReturn($this->package2->email);
        $package3 = Mockery::mock(Package::class);
        $package3->shouldReceive('getAttribute')->with('id')->andReturn($this->package3->id);
        $package3->shouldReceive('getAttribute')->with('pickup_address_id')->andReturn($this->pickupAddress3->id);
        $package3->shouldReceive('getAttribute')->with('dropoff_address_id')->andReturn($this->dropoffAddress3->id);
        $package3->shouldReceive('getAttribute')->with('trace_code')->andReturn($this->package3->trace_code);
        $package3->shouldReceive('getAttribute')->with('name')->andReturn($this->package3->name);
        $package3->shouldReceive('getAttribute')->with('email')->andReturn($this->package3->email);

        // Mock package repo
        $packageRepo = Mockery::mock(PackagesRepository::class);
        $packageRepo->shouldReceive('find')->with($this->package1->id)->andReturn($package1);
        $packageRepo->shouldReceive('find')->with($this->package2->id)->andReturn($package2);
        $packageRepo->shouldReceive('find')->with($this->package3->id)->andReturn($package3);
        $this->app->instance(Package::class, $packageRepo);

        // Mock PDF
        $pdf = Mockery::mock(PDFFile::class);
        $pdf->shouldReceive('loadHTML')->andReturnSelf();
        $pdf->shouldReceive('download')->andReturn('mock-pdf');
        $this->app->instance(PDFFile::class, $pdf);

        // Mock label controller
        $labelController = new LabelController();
        $result = $labelController->generateLabels($generateLabelsRequest);

        // Get content type and assert it's a PDF file
        $contentType = $result->headers->get('Content-Type');
        $this->assertEquals('application/pdf', $contentType);

        // Get file name from headers and assert its format
        $filename = $result->headers->get('Content-Disposition');
        $matches = [];
        preg_match('/filename="(.+)"/', $filename, $matches);
        if (count($matches) >= 2) {
            $filename = $matches[1];
        }
        $this->assertEquals('labelCollection_' . date('d-m-Y H:i:s') . '.pdf', $filename);

        // Get PDF file and assert it exists
        $pdfContent = $result->getContent();
        if (!file_exists($this->directoryName)) {
            mkdir($this->directoryName);
        }
        $filePath = $this->directoryName . '/' . $this->fileName;
        file_put_contents($filePath, $pdfContent);
        $this->assertFileExists($filePath);

        // Get PDF contents
        $parser = new PDFParser();
        $parsedPdf = $parser->parseFile($filePath);
        $pdfText = $parsedPdf->getText();

        // Assert correct information in PDF
        $this->assertEquals(3, $this->countPages($pdfContent));
        $this->checkPDFForText($pdfText, 'Pakketlabel');
        $this->checkPDFForText($pdfText, 'Adres:');
        $this->checkPDFForText($pdfText, $this->package1->trace_code);
        $this->checkPDFForText($pdfText, $this->package1->dropoff_address->street_name);
        $this->checkPDFForText($pdfText, $this->package1->dropoff_address->house_number);
        $this->checkPDFForText($pdfText, $this->package1->dropoff_address->postal_code);
        $this->checkPDFForText($pdfText, $this->package1->dropoff_address->city);
        $this->checkPDFForText($pdfText, $this->package1->dropoff_address->country);
        $this->checkPDFForText($pdfText, $this->package2->trace_code);
        $this->checkPDFForText($pdfText, $this->package2->dropoff_address->street_name);
        $this->checkPDFForText($pdfText, $this->package2->dropoff_address->house_number);
        $this->checkPDFForText($pdfText, $this->package2->dropoff_address->postal_code);
        $this->checkPDFForText($pdfText, $this->package2->dropoff_address->city);
        $this->checkPDFForText($pdfText, $this->package2->dropoff_address->country);
        $this->checkPDFForText($pdfText, $this->package3->trace_code);
        $this->checkPDFForText($pdfText, $this->package3->dropoff_address->street_name);
        $this->checkPDFForText($pdfText, $this->package3->dropoff_address->house_number);
        $this->checkPDFForText($pdfText, $this->package3->dropoff_address->postal_code);
        $this->checkPDFForText($pdfText, $this->package3->dropoff_address->city);
        $this->checkPDFForText($pdfText, $this->package3->dropoff_address->country);
    }

    private function countPages($pdfContent): int
    {
        return preg_match_all('/\/Page\W/', $pdfContent);
    }

    private function checkPDFForText($pdfText, $searchText)
    {
        $this->assertTrue(str_contains($pdfText, $searchText));
    }

    public function tearDown(): void
    {
        Mockery::close();

        $filePath = $this->directoryName . '/' . $this->fileName;
        unlink($filePath);
    }
}
