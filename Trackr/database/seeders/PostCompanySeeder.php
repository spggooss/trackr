<?php

namespace Database\Seeders;

use App\Models\Package\PostCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCompanySeeder extends Seeder
{
    public function run(): void
    {
        // Create post companies
        $postCompanies = [
            [
                'name' => 'PostNL',
                'price' => 6.25
            ],
            [
                'name' => 'DHL',
                'price' => 9.00
            ],
            [
                'name' => 'DPD',
                'price' => 4.99
            ],
            [
                'name' => 'UPS',
                'price' => 14.20
            ],
            [
                'name' => 'TNT',
                'price' => 8.49
            ],
        ];

        // Insert post companies
        foreach ($postCompanies as $postCompany) {
            PostCompany::create($postCompany);
        }
    }
}
