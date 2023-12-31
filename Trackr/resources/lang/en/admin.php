<?php
return [
    'users' => [
        'title' => 'Users',
        'index' => [
            'table' => [
                'name' => 'Name',
                'email' => 'Email Address',
                'webshop_name' => 'Webshop name',
                'webshop' => 'Webshop',
                'role' => 'Role',
            ],
            'page' => 'Page',
            'limit' => 'Limit',
            'search' => 'Search',
            'sort' => 'Sort',
            'search-placeholder' => 'Search by name or email address',
            'create-user' => 'Create User',
            'search-button' => 'Search',
            'sorting' => [
                'choose' => '-- Choose --',
                'default' => 'Default',
                'name-asc' => 'Name (ascending)',
                'name-desc' => 'Name (descending)',
                'email-asc' => 'Email (ascending)',
                'email-desc' => 'Email (descending)',
            ],
            'edit' => 'Edit',
        ],
        'create' => [
            'title' => 'Create User',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'webshop_name' => 'Webshop name',
            'role' => 'Role',
            'submit' => 'Create',
        ],
        'update' => [
            'title' => 'Update User',
            'submit' => 'Update',
        ],
    ],
    'webshops' => [
        'index' => [
            'create-webshop' => 'Create Webshop',
            'search' => 'Search',
            'search-placeholder' => 'Search by name',
            'sort' => 'Sort',
            'sorting' => [
                'choose' => '-- Choose --',
                'default' => 'Default',
                'name-asc' => 'Name (ascending)',
                'name-desc' => 'Name (descending)',
            ],
            'search-button' => 'Search',
            'table' => [
                'name' => 'Name',
            ],
        ],
        'create' => [
            'title' => 'Create Webshop',
            'name' => 'Name',
            'submit' => 'Create',
        ],
    ],
    'packages' => [
        'create' => [
            'title' => 'Packages',
            'name' => 'Name',
            'email' => 'Email',
            'pickup-postal-code' => 'Pickup Postal Code',
            'pickup-city' => 'Pickup City',
            'pickup-street-name' => 'Pickup Street',
            'pickup-house-number' => 'Pickup Number',
            'pickup-country' => 'Pickup Country',
            'dropoff-postal-code' => 'Dropoff Postal Code',
            'dropoff-city' => 'Dropoff City',
            'dropoff-street-name' => 'Dropoff Street',
            'dropoff-house-number' => 'Dropoff Number',
            'dropoff-country' => 'Dropoff Country',
            'post-company' => 'Post Company',
            'post-company-placeholder' => 'No post company',
            'submit' => 'Create Package',
        ],
        'index' => [
            'title' => 'Packages',
            'create-package' => 'Create Package',
            'import-csv' => 'Import CSV',
            'search' => 'Search Term',
            'search-placeholder' => 'Search Term',
            'sort' => 'Sorting Term',
            'sorting' => [
                'choose' => '-- Choose --',
                'default' => 'Default',
                'pickup-date-asc' => 'Pickup date (ascending)',
                'pickup-date-desc' => 'Pickup date (descending)',
                'email-asc' => 'Email (ascending)',
                'email-desc' => 'Email (descending)',
            ],
            'search-button' => 'Search',
            'generate-label-all' => 'Generate all labels',
            'no_records' => 'No records found.',
            'name' => 'Name',
            'email' => 'Email',
            'status' => 'Status',
            'pickup-date' => 'Pickup Date',
            'pickup-time' => 'Pickup Time',
            'pickup-address' => 'Pickup Address',
            'dropoff-address' => 'Dropoff Address',
            'post-company' => 'Post Company',
            'trace-code' => 'Trace Code',
            'change-pickup-time' => [
                'label' => 'Change Pickup Time',
                'submit' => 'Submit',
            ],
            'generate-label' => 'Generate label',
            'not-set' => 'Not set.',
        ]
    ]
];
