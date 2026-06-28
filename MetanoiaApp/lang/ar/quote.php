<?php

// Egyptian Arabic labels for the public quote form's select options.
// Keys MUST match App\Models\QuoteRequest constants (the stored value stays canonical).

return [
    'salutations' => [
        'Mr.' => 'السيد',
        'Mrs.' => 'السيدة',
        'Eng.' => 'مهندس',
        'Dr.' => 'دكتور',
        'Other' => 'أخرى',
    ],
    'segments' => [
        'factory' => 'مصنع / صناعي',
        'farm' => 'مزرعة / زراعي',
        'solar_company' => 'شركة طاقة شمسية',
        'contractor' => 'مقاول / تنفيذ',
        'freelancer' => 'فريلانسر',
        'other' => 'أخرى',
    ],
    'services' => [
        'supply' => 'توريد فقط',
        'install' => 'تركيب فقط',
        'both' => 'توريد + تركيب',
    ],
    'system_types' => [
        'on_grid' => 'متصل بالشبكة',
        'off_grid' => 'مستقل عن الشبكة',
        'pumping' => 'ضخ بالطاقة الشمسية',
        'upgrade' => 'ترقية نظام قائم',
        'not_sure' => 'لسه مش متأكد',
    ],
    'monthly_bills' => [
        'under_10k' => 'أقل من 10,000 جنيه',
        '10_50k' => '10,000 – 50,000',
        '50_200k' => '50,000 – 200,000',
        'over_200k' => 'أكثر من 200,000',
        'not_sure' => 'مش متأكد',
    ],
    'timelines' => [
        'asap' => 'في أقرب وقت',
        '1_3' => '1 – 3 شهور',
        '3_6' => '3 – 6 شهور',
        'exploring' => 'مجرد استكشاف',
    ],
    'contact_methods' => [
        'whatsapp' => 'واتساب',
        'phone' => 'مكالمة هاتفية',
        'email' => 'إيميل',
    ],

    'success' => 'شكرًا — استلمنا طلبك، وفريقنا هيتواصل معاك في أقرب وقت.',
];
