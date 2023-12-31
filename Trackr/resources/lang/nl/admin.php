<?php
return [
    'users' => [
        'title' => 'Gebruikers',
        'index' => [
            'table' => [
                'name' => 'Naam',
                'email' => 'E-mailadres',
                'webshop_name' => 'Webshopnaam',
                'webshop' => 'Webshop',
                'role' => 'Rol',
            ],
            'page' => 'Pagina',
            'limit' => 'Limiet',
            'search' => 'Zoeken',
            'sort' => 'Sorteren',
            'search-placeholder' => 'Zoeken op naam of e-mailadres',
            'create-user' => 'Gebruiker aanmaken',
            'search-button' => 'Zoeken',
            'sorting' => [
                'choose' => '-- Kies --',
                'default' => 'Standaard',
                'name-asc' => 'Naam (oplopend)',
                'name-desc' => 'Naam (aflopend)',
                'email-asc' => 'E-mailadres (oplopend)',
                'email-desc' => 'E-mailadres (aflopend)',
            ],
            'edit' => 'Bewerken',
        ],
        'create' => [
            'title' => 'Gebruiker aanmaken',
            'name' => 'Naam',
            'email' => 'E-mailadres',
            'password' => 'Wachtwoord',
            'webshop_name' => 'Webshopnaam',
            'role' => 'Rol',
            'submit' => 'Aanmaken',
        ],
        'update' => [
            'title' => 'Gebruiker bewerken',
            'submit' => 'Bijwerken',
        ],
    ],
    'webshops' => [
        'index' => [
            'create-webshop' => 'Webshop aanmaken',
            'search' => 'Zoeken',
            'search-placeholder' => 'Zoeken op naam',
            'sort' => 'Sorteren',
            'sorting' => [
                'choose' => '-- Kies --',
                'default' => 'Standaard',
                'name-asc' => 'Naam (oplopend)',
                'name-desc' => 'Naam (aflopend)',
            ],
            'search-button' => 'Zoeken',
            'table' => [
                'name' => 'Naam',
            ],
        ],
        'create' => [
            'title' => 'Webshop aanmaken',
            'name' => 'Naam',
            'submit' => 'Aanmaken',
        ],
    ],
    'packages' => [
        'create' => [
            'title' => 'Pakketten',
            'name' => 'Naam',
            'email' => 'E-mail',
            'pickup-postal-code' => 'Ophaalpostcode',
            'pickup-city' => 'Ophaalstad',
            'pickup-street-name' => 'Ophaalstraat',
            'pickup-house-number' => 'Ophaalnummer',
            'pickup-country' => 'Ophaalland',
            'dropoff-postal-code' => 'Afleverpostcode',
            'dropoff-city' => 'Afleverstad',
            'dropoff-street-name' => 'Afleverstraat',
            'dropoff-house-number' => 'Aflevernummer',
            'dropoff-country' => 'Afleverland',
            'post-company' => 'Postbedrijf',
            'post-company-placeholder' => '-- Kies postbedrijf --',
            'submit' => 'Pakket aanmaken',
        ],
        'index' => [
            'title' => 'Pakketten',
            'create-package' => 'Pakket aanmaken',
            'import-csv' => 'CSV importeren',
            'search' => 'Zoekterm',
            'search-placeholder' => 'Zoekterm',
            'sort' => 'Sorteervolgorde',
            'sorting' => [
                'choose' => '-- Kies --',
                'default' => 'Standaard',
                'pickup-date-asc' => 'Ophaaldatum (oplopend)',
                'pickup-date-desc' => 'Ophaaldatum (aflopend)',
                'email-asc' => 'E-mail (oplopend)',
                'email-desc' => 'E-mail (aflopend)',
            ],
            'search-button' => 'Zoeken',
            'generate-label-all' => 'Alle labels genereren',
            'no_records' => 'Geen pakketten gevonden.',
            'name' => 'Naam',
            'email' => 'E-mail',
            'status' => 'Status',
            'pickup-date' => 'Ophaaldatum',
            'pickup-time' => 'Ophaaltijd',
            'pickup-address' => 'Ophaaladres',
            'dropoff-address' => 'Afleveradres',
            'trace-code' => 'Traceercode',
            'post-company' => 'Postbedrijf',
            'change-pickup-time' => [
                'label' => 'Ophaaltijd wijzigen',
                'submit' => 'Verzenden',
            ],
            'generate-label' => 'Label genereren',
            'not-set' => 'Niet ingesteld.',
        ]
    ]
];
