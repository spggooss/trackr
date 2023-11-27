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

class GenerateLabelTest extends TestCase
{
    use DatabaseTransactions;

    var Address $pickupAddress;
    var Address $dropoffAddress;
    var Package $package;

    var string $directoryName = './tests/files';
    var string $fileName = 'label_unit_test.pdf';

    public function setUp(): void
    {
        parent::setUp();

        $addressRepo = Mockery::mock(AddressRepository::class);
        $pickupAddress = new Address([
            'street_name' => 'Fake Street',
            'house_number' => '123',
            'postal_code' => '1234AB',
            'city' => 'Fake City',
            'country' => 'Fake Country',
        ]);
        $dropoffAddress = new Address([
            'street_name' => 'Fake Street',
            'house_number' => '456',
            'postal_code' => '5678AB',
            'city' => 'Fake City',
            'country' => 'Fake Country',
        ]);
        $addressRepo->shouldReceive('store')->once()->andReturnUsing(function ($pickupAddress) {
            $pickupAddress->save();
            return $pickupAddress;
        });
        $addressRepo->shouldReceive('store')->once()->andReturnUsing(function ($dropoffAddress) {
            $dropoffAddress->save();
            return $dropoffAddress;
        });
        $this->pickupAddress = $addressRepo->store($pickupAddress);
        $this->dropoffAddress = $addressRepo->store($dropoffAddress);

        $packageRepo = Mockery::mock(PackagesRepository::class);
        $package = new Package([
            'status' => PackageStatus::CREATE(PackageStatus::REGISTERED),
            'name' => 'Fake Name',
            'email' => 'fake@email.com',
            'trace_code' => "TR" . Str::random(),
        ]);
        $packageRepo->shouldReceive('store')->once()->andReturn($package);
        $this->package = $packageRepo->store($package);
        $this->package->assignPickupAddress($this->pickupAddress);
        $this->package->assignDropOffAddress($this->dropoffAddress);
    }

    /**
     * Test if a PDF is generated.
     * Test if the generated PDF for a label contains the correct information.
     */
    public function testGeneratedLabelPDF(): void
    {
        // Mock label request
        $generateLabelRequest = Mockery::mock(GenerateLabelRequest::class);
        $generateLabelRequest->shouldReceive('getPackageId')->andReturn($this->package->id);

        // Mock custom package
        $package = Mockery::mock(Package::class);
        $package->shouldReceive('getAttribute')->with('id')->andReturn($this->package->id);
        $package->shouldReceive('getAttribute')->with('pickup_address_id')->andReturn($this->pickupAddress->id);
        $package->shouldReceive('getAttribute')->with('dropoff_address_id')->andReturn($this->dropoffAddress->id);
        $package->shouldReceive('getAttribute')->with('trace_code')->andReturn($this->package->trace_code);
        $package->shouldReceive('getAttribute')->with('name')->andReturn($this->package->name);
        $package->shouldReceive('getAttribute')->with('email')->andReturn($this->package->email);

        // Mock package repo
        $packageRepo = Mockery::mock(PackagesRepository::class);
        $packageRepo->shouldReceive('find')->with($this->package->id)->andReturn($package);
        $this->app->instance(Package::class, $packageRepo);

        // Mock PDF
        $pdf = Mockery::mock(PDFFile::class);
        $pdf->shouldReceive('loadHTML')->andReturnSelf();
        $pdf->shouldReceive('download')->andReturn('mock-pdf');
        $this->app->instance(PDFFile::class, $pdf);

        // Mock label controller
        $labelController = new LabelController();
        $result = $labelController->generateLabel($generateLabelRequest);

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
        $this->assertEquals('label_' . date('d-m-Y H:i:s') . '.pdf', $filename);

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
        $this->checkPDFForText($pdfText, 'Pakketlabel');
        $this->checkPDFForText($pdfText, 'Adres:');
        $this->checkPDFForText($pdfText, $this->package->trace_code);
        $this->checkPDFForText($pdfText, $this->package->dropoff_address->street_name);
        $this->checkPDFForText($pdfText, $this->package->dropoff_address->house_number);
        $this->checkPDFForText($pdfText, $this->package->dropoff_address->postal_code);
        $this->checkPDFForText($pdfText, $this->package->dropoff_address->city);
        $this->checkPDFForText($pdfText, $this->package->dropoff_address->country);
    }

    private function checkPDFForText($pdfText, $searchText) {
        $this->assertTrue(str_contains($pdfText, $searchText));
    }

    public function tearDown(): void
    {
        Mockery::close();

        $filePath = $this->directoryName . '/' . $this->fileName;
        unlink($filePath);
    }
}
