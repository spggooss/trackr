<?php

namespace App\Http\Controllers\Web\Packages;

use App\Business\Packages\LabelGenerator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Packages\Requests\GenerateLabelRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class LabelController extends Controller
{
    public function generateLabels(GenerateLabelRequest $request)
    {
        $package_ids = $request->getPackageIds();
        $html = '';

        $labelGenerator = new LabelGenerator();
        foreach ($package_ids as $package_id) {
            $html .= $labelGenerator->generateLabelForPackageId($package_id);
        }

        $pdf = Pdf::loadHTML($html);
        return $pdf->download('labelCollection_' . date('d-m-Y H:i:s') . '.pdf');
    }

    public function generateLabel(GenerateLabelRequest $request)
    {
        $labelGenerator = new LabelGenerator();
        $pdf = Pdf::loadHTML($labelGenerator->generateLabelForPackageId($request->getPackageId()));
        return $pdf->download('label_' . date('d-m-Y H:i:s') . '.pdf');
    }
}
