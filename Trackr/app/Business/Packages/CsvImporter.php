<?php

namespace App\Business\Packages;

use App\Models\Address\Address;
use App\Models\Address\AddressRepository;
use App\Models\Package\Package;
use App\Models\Package\PackagesRepository;
use App\Models\Package\PackageStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CsvImporter
{
    public function __construct(private PackagesRepository $packagesRepository, private AddressRepository $addressRepository)
    {
    }
    public function importCsv($handle){
        fgetcsv($handle);

        Log::info('looping the csv');
        try{
        while (($data = fgetcsv($handle)) !== false) {
            $name = $data[0];
            $email = $data[1];
            $pickupStreetName = $data[2];
            $pickupHouseNumber = $data[3];
            $pickupPostalCode = $data[4];
            $pickupCity = $data[5];
            $pickupCountry = $data[6];
            $dropoffStreetName = $data[7];
            $dropoffHouseNumber = $data[8];
            $dropoffPostalCode = $data[9];
            $dropoffCity = $data[10];
            $dropoffCountry = $data[11];

            // Create the package
            $package = new Package();
            $package->name = $name;
            $package->email = $email;

            $package->status = PackageStatus::create(PackageStatus::REGISTERED);

            // Create the pickup address
            $pickupAddress = new Address();
            $pickupAddress->street_name = $pickupStreetName;
            $pickupAddress->house_number = $pickupHouseNumber;
            $pickupAddress->postal_code = $pickupPostalCode;
            $pickupAddress->city = $pickupCity;
            $pickupAddress->country = $pickupCountry;
            $this->addressRepository->store($pickupAddress);

            $package->pickup_address()->associate($pickupAddress);

            // Create the drop-off address
            $dropoffAddress = new Address();
            $dropoffAddress->street_name = $dropoffStreetName;
            $dropoffAddress->house_number = $dropoffHouseNumber;
            $dropoffAddress->postal_code = $dropoffPostalCode;
            $dropoffAddress->city = $dropoffCity;
            $dropoffAddress->country = $dropoffCountry;
            $this->addressRepository->store($dropoffAddress);

            $package->dropoff_address()->associate($dropoffAddress);

            $package = $this->packagesRepository->store($package);


            if (Auth::user()->webshop !== null) {

                $package->assignWebshop(Auth::user()->webshop);
            }
        }
        } catch(\Exception $exception){
dd($exception);
        }

        fclose($handle);
    }

}
