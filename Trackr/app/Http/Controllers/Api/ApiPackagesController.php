<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Requests\ApiPackageCreateRequest;
use App\Http\Controllers\Api\Requests\ApiPackageUpdateStatusRequest;
use App\Models\Address\Address;
use App\Models\Address\AddressRepository;
use App\Models\Package\Package;
use App\Models\Package\PackagesRepository;
use App\Models\Package\PackageStatus;
use App\Models\User\UsersRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class ApiPackagesController extends Controller
{

    public function __construct(private PackagesRepository $packagesRepository, private AddressRepository $addressRepository, private UsersRepository $usersRepository)
    {

    }

   public function changePackageStatus(int $packageId, ApiPackageUpdateStatusRequest $request): string
   {
        $status = $request->getStatus();

        $package =  $this->packagesRepository->findById($packageId);

        $package->status = $status;
       return $this->packagesRepository->store($package);
   }
   public function registerPackage(ApiPackageCreateRequest $request): string
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
           'status' => PackageStatus::create(PackageStatus::REGISTERED),
           'name' => $request->getName(),
           'email' => $request->getEmail(),
       ]);
       $package = $this->packagesRepository->store($package);
       $package->assignPickupAddress($pickupAddress);
       $package->assignDropOffAddress($dropoffAddress);

       $user = $this->usersRepository->findByEmail($request->getEmail());

       if ($user) {
           $package->assignUser($user);
       }

       return $this->packagesRepository->findById($package->id, ['pickup_address', 'dropoff_address']);
   }
}

