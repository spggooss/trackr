<?php

namespace App\Http\Controllers\Web\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;

class CalenderController extends Controller
{
    public function index(Request $request, PackagesRepository $packagesRepository)
    {
        if($request->ajax()) {
            $data = $packagesRepository->getPackages();
            return response()->json($data);
        }
        return view('welcome');
    }
}
