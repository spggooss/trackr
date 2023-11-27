<?php

namespace App\Business\Packages;

use App\Models\Package\Package;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class LabelGenerator
{
    public function generateLabelForPackageId(int $package_id)
    {
        $package = Package::find($package_id);
        $address = $package->dropoff_address;
        $addressInfo = [];
        foreach (json_decode($address) as $key => $value) {
            if ($key !== 'id' && $key !== 'created_at' && $key !== 'updated_at') {
                $row = [$key, $value];
                $addressInfo[] = $row;
            }
        }

        $html = '<html><body>';
        $html .= '<h1>Pakketlabel</h1>';
        $html .= '<p>Adres:</p>';
        foreach ($addressInfo as $info) {
            $html .= '<p>' . $info[1] . '</p>';
        }
        $html .= '</body></html>';

        $writer = new PngWriter();
        $qrCode = QrCode::create(route('packages.show', ['packageId' => $package->id]))
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $result = $writer->write($qrCode);
        $dataUri = $result->getDataUri();

        $html .= '<img src="' . $dataUri . '">';
        $html .= '<p style="page-break-after: always">' . $package->trace_code . '</p>';

        return $html;
    }
}
