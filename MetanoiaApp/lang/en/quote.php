<?php

// Localized labels for the public quote form's select options.
// Keys MUST match App\Models\QuoteRequest constants (used for validation + admin).

return [
    'salutations' => [
        'Mr.' => 'Mr.',
        'Mrs.' => 'Mrs.',
        'Eng.' => 'Eng.',
        'Dr.' => 'Dr.',
        'Other' => 'Other',
    ],
    'segments' => [
        'factory' => 'Factory / industrial',
        'farm' => 'Farm / agricultural',
        'solar_company' => 'Solar company',
        'contractor' => 'Contractor / EPC',
        'freelancer' => 'Freelancer',
        'other' => 'Other',
    ],
    'services' => [
        'supply' => 'Supply only',
        'install' => 'Installation only',
        'both' => 'Supply + installation',
    ],
    'system_types' => [
        'on_grid' => 'On-grid',
        'off_grid' => 'Off-grid',
        'pumping' => 'Solar pumping',
        'upgrade' => 'Upgrade existing',
        'not_sure' => 'Not sure yet',
    ],
    'monthly_bills' => [
        'under_10k' => 'Under 10,000 EGP',
        '10_50k' => '10,000 – 50,000',
        '50_200k' => '50,000 – 200,000',
        'over_200k' => 'Over 200,000',
        'not_sure' => 'Not sure',
    ],
    'timelines' => [
        'asap' => 'As soon as possible',
        '1_3' => '1 – 3 months',
        '3_6' => '3 – 6 months',
        'exploring' => 'Just exploring',
    ],
    'contact_methods' => [
        'whatsapp' => 'WhatsApp',
        'phone' => 'Phone call',
        'email' => 'Email',
    ],

    'success' => 'Thanks — your request has been received. Our team will get back to you shortly.',
];
