<?php

namespace App\Http\Controllers\Web\Packages;

use App\Business\Packages\CsvImporter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\GeneralRequests\PaginatedRequest;
use App\Http\Controllers\Web\GeneralRequests\SortingRequest;
use App\Http\Controllers\Web\Packages\Requests\AddPackageToAccountRequest;
use App\Http\Controllers\Web\Packages\Requests\ChangePickupTimeRequest;
use App\Http\Controllers\Web\Packages\Requests\ChangePostCompanyRequest;
use App\Http\Controllers\Web\Packages\Requests\FindPackageRequest;
use App\Http\Controllers\Web\Packages\Requests\ImportCsvRequest;
use App\Http\Controllers\Web\Packages\Requests\PackageCreateRequest;
use App\Http\Controllers\Web\Packages\Requests\SearchRequest;
use App\Models\Address\Address;
use App\Models\Address\AddressRepository;
use App\Models\Package\Package;
use App\Models\Package\PackagesRepository;
use App\Models\Package\PackageStatus;
use App\Models\Package\PostCompany;
use App\Models\Package\PostCompanyRepository;
use App\Models\User\UsersRepository;
use App\Models\Webshop\Webshop;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PackagesController extends Controller
{
    public function __construct(private PackagesRepository $packagesRepository, private AddressRepository $addressRepository, private UsersRepository $usersRepository, private PostCompanyRepository $postCompanyRepository)
    {
    }

    public function index(PaginatedRequest $request, SearchRequest $searchRequest, SortingRequest $sortingRequest)
    {
        $searchTerm = $searchRequest->getSearchTerm();
        $page = $request->getPage();
        $limit = $request->getLimit();

        $postCompanies = $this->postCompanyRepository->all();
        $packages = $this->packagesRepository->getPaged($page, $limit, $sortingRequest->getOrderBy() ?? 'id', $sortingRequest->getOrderDirection() ?? 'asc', $searchTerm);

        return view('packages.super_admin.index')->with(['packages' => $packages, 'postCompanies' => $postCompanies, 'searchTerm' => $searchTerm, 'page' => $page, 'limit' => $limit, 'sort' => $sortingRequest->getSort()]);
    }

    public function webshopIndex(Webshop $webshop, PaginatedRequest $request, SearchRequest $searchRequest, SortingRequest $sortingRequest)
    {

        if (Auth::user()->webshop_id !== $webshop->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $searchTerm = $searchRequest->getSearchTerm();
        $page = $request->getPage();
        $limit = $request->getLimit();

        $postCompanies = $this->postCompanyRepository->all();
        $packages = $this->packagesRepository->getPagedForWebshop($webshop, $page, $limit, $sortingRequest->getOrderBy() ?? 'id', $sortingRequest->getOrderDirection() ?? 'asc', $searchTerm);

        return view('packages.admin.index')->with(['packages' => $packages, 'postCompanies' => $postCompanies, 'searchTerm' => $searchTerm, 'page' => $page, 'limit' => $limit, 'sort' => $sortingRequest->getSort()]);
    }

    public function create()
    {
        $postCompanies = $this->postCompanyRepository->all();

        return view('packages.admin.create')->with(['postCompanies' => $postCompanies]);
    }

    public function store(PackageCreateRequest $request)
    {
        $pickupAddress = new Address([
            'street_name' => $request->getPickupStreetName(),
            'house_number' => $request->getPickupHouseNumber(),
            'postal_code' => $request->getPickupPostalCode(),
            'city' => $request->getPickupCity(),
            'country' => $request->getPickupCountry(),
        ]);
        $dropoffAddress = new Address([
            'street_name' => $request->getDropoffStreetName(),
            'house_number' => $request->getDropoffHouseNumber(),
            'postal_code' => $request->getDropoffPostalCode(),
            'city' => $request->getDropoffCity(),
            'country' => $request->getDropoffCountry(),
        ]);

        $pickupAddress = $this->addressRepository->store($pickupAddress);
        $dropoffAddress = $this->addressRepository->store($dropoffAddress);

        $package = new Package([
            'status' => PackageStatus::CREATE(PackageStatus::REGISTERED),
            'name' => $request->getName(),
            'email' => $request->getEmail(),
        ]);

        if (Auth::user()->webshop_id !== null) {
            $package->webshop_id = Auth::user()->webshop_id;
        }

        $this->packagesRepository->store($package);

        $user = $this->usersRepository->findByEmail($request->getEmail());

        if ($user) {
            $package->assignUser($user);
        }

        $package->assignPickupAddress($pickupAddress);
        $package->assignDropOffAddress($dropoffAddress);

        $postCompanyId = $request->getPostCompanyId();
        if ($postCompanyId) {
            $postCompany = $this->postCompanyRepository->findById($postCompanyId);
            if ($postCompany) {
                $package->assignPostCompany($postCompany);
            }
            $package->trace_code = $this->getTraceCode($postCompany);
        }

        $this->packagesRepository->store($package);

        $package->assignWebshop(Auth::user()->webshop);

        return redirect()->route('admin.packages.webshop.index', ['webshop' => Auth::user()->webshop]);
    }

    public function findPackage(FindPackageRequest $request)
    {
        $traceCode = $request->getTraceCode();
        $postalCode = $request->getPostalCode();
        $package = $this->packagesRepository->findByTraceCodeAndPostalCode($traceCode, $postalCode);

        if ($package !== null) {
            return view('packages.show', ['package' => $package]);
        } else {
            return redirect()->back()->with('error', 'No package found.');
        }
    }

    public function addPackageToAccount(AddPackageToAccountRequest $request)
    {
        $package = $this->packagesRepository->findById($request->getPackageId());
        $user = $this->usersRepository->findByEmail($request->getEmail());

        if ($package !== null && $user !== null) {
            $package->assignUser($user);
        }

        return redirect()->back();
    }

    public function show(int $packageId)
    {
        $package = $this->packagesRepository->findById($packageId);
        return view('packages.show', ['package' => $package]);
    }

    public function import(ImportCsvRequest $request)
    {
        $file = $request->getFile();

        // Check if a file was uploaded
        if (!$file) {
            return redirect()->back()->with('error', 'Please select a file to upload.');
        }

        // Process the CSV file
        $filePath = $file->getRealPath();
        $handle = fopen($filePath, 'r');

        if (!$handle) {
            // Handle file opening error
            return redirect()->back()->with('error', 'Failed to open the CSV file.');
        }

        $csvImporter = new CsvImporter($this->packagesRepository, $this->addressRepository);
        $csvImporter->importCsv($handle);


        return redirect()->back()->with('success', 'Packages created successfully.');
    }

    public function packagesForUser(Guard $guard, PaginatedRequest $request, SortingRequest $sortingRequest)
    {
        $user = $guard->user();

        $page = $request->getPage();
        $limit = $request->getLimit();

        $packages = $this->packagesRepository->getPagedForUser($user, $page, $limit, $sortingRequest->getOrderBy() ?? 'id', $sortingRequest->getOrderDirection() ?? 'asc');
        return view('packages.user.index')->with(['packages' => $packages]);
    }

    public function changePostCompany(int $packageId, ChangePostCompanyRequest $request)
    {
        $package = $this->packagesRepository->findById($packageId);
        $postCompany = $this->postCompanyRepository->findById($request->getPostCompany());
        $package->assignPostCompany($postCompany);
        $package->trace_code = $this->getTraceCode($postCompany);

        $this->packagesRepository->store($package);

        return redirect()->back()->with('success', 'Post company changed successfully.');
    }

    public function changePickupTime(int $packageId, ChangePickupTimeRequest $request)
    {
        $package = $this->packagesRepository->findById($packageId);
        $pickupTime = $request->getPickupTime();
        $package->pickup_date = $pickupTime;
        $package->pickup_time = $pickupTime;

        $this->packagesRepository->store($package);

        return redirect()->back()->with('success', 'Pickup time changed successfully.');
    }

    private function getTraceCode(PostCompany $postCompany)
    {
        switch ($postCompany->name) {
            case "PostNL":
                return "PNL" . Str::random();
            case "DHL":
                return "DHL" . Str::random();
            case "DPD":
                return "DPD" . Str::random();
            case "UPS":
                return "UPS" . Str::random();
            case "TNT":
                return "TNT" . Str::random();
            default:
                return "TR" . Str::random();
        }
    }
}
