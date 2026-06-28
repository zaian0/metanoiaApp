<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'salutation', 'name', 'phone', 'email', 'company',
        'segment', 'location',
        'service', 'system_type', 'monthly_bill', 'timeline',
        'preferred_contact', 'details',
        'status', 'source', 'ip',
    ];

    public const SALUTATIONS = ['Mr.', 'Mrs.', 'Eng.', 'Dr.', 'Other'];

    public const SEGMENTS = [
        'factory' => 'Factory / industrial',
        'farm' => 'Farm / agricultural',
        'solar_company' => 'Solar company',
        'contractor' => 'Contractor / EPC',
        'freelancer' => 'Freelancer',
        'other' => 'Other',
    ];

    public const SERVICES = [
        'supply' => 'Supply only',
        'install' => 'Installation only',
        'both' => 'Supply + installation',
    ];

    public const SYSTEM_TYPES = [
        'on_grid' => 'On-grid',
        'off_grid' => 'Off-grid',
        'pumping' => 'Solar pumping',
        'upgrade' => 'Upgrade existing',
        'not_sure' => 'Not sure yet',
    ];

    public const MONTHLY_BILLS = [
        'under_10k' => 'Under 10,000 EGP',
        '10_50k' => '10,000 – 50,000',
        '50_200k' => '50,000 – 200,000',
        'over_200k' => 'Over 200,000',
        'not_sure' => 'Not sure',
    ];

    public const TIMELINES = [
        'asap' => 'As soon as possible',
        '1_3' => '1 – 3 months',
        '3_6' => '3 – 6 months',
        'exploring' => 'Just exploring',
    ];

    public const CONTACT_METHODS = [
        'whatsapp' => 'WhatsApp',
        'phone' => 'Phone call',
        'email' => 'Email',
    ];

    public const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'quoted' => 'Quoted',
        'closed' => 'Closed',
    ];

    /** Option maps shipped to the Inertia form + reused by the dashboard. */
    public static function options(): array
    {
        return [
            'salutations' => self::SALUTATIONS,
            'segments' => self::SEGMENTS,
            'services' => self::SERVICES,
            'systemTypes' => self::SYSTEM_TYPES,
            'monthlyBills' => self::MONTHLY_BILLS,
            'timelines' => self::TIMELINES,
            'contactMethods' => self::CONTACT_METHODS,
        ];
    }
}
