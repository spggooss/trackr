<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package\PackagesRepository;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{

    public function __construct(private PackagesRepository $packagesRepository)
    {
    }

    public function index()
    {
        $webshopId = Auth::user()->webshop->id;
        $packages = $this->packagesRepository->getAllForWebshop($webshopId);

        return view('admin.calendar')->with(['packages' => $packages]);
    }
}
