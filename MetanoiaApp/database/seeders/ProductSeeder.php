<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'solar-panels', 'en' => 'Solar Panels', 'ar' => 'الألواح الشمسية', 'icon' => 'sun'],
            ['slug' => 'inverters', 'en' => 'Inverters', 'ar' => 'الإنفرتر', 'icon' => 'bolt'],
            ['slug' => 'combiner-boxes', 'en' => 'Combiner Boxes', 'ar' => 'صناديق التجميع', 'icon' => 'box'],
            ['slug' => 'cables-connectors', 'en' => 'Cables & Connectors', 'ar' => 'الكابلات والموصلات', 'icon' => 'plug'],
            ['slug' => 'circuit-breakers', 'en' => 'Circuit Breakers', 'ar' => 'قواطع الكهرباء', 'icon' => 'shield'],
            ['slug' => 'water-pumping', 'en' => 'Water Pumping', 'ar' => 'ضخ المياه', 'icon' => 'droplet'],
        ];

        $sort = 1;
        foreach ($categories as $c) {
            ProductCategory::updateOrCreate(
                ['slug' => $c['slug']],
                ['name_en' => $c['en'], 'name_ar' => $c['ar'], 'icon' => $c['icon'], 'sort_order' => $sort++],
            );
        }

        $cat = ProductCategory::pluck('id', 'slug');

        $products = [
            [
                'cat' => 'solar-panels', 'featured' => true,
                'name_en' => 'Mono PERC 580W Bifacial Module', 'name_ar' => 'لوح أحادي PERC بقدرة 580 وات ثنائي الوجه',
                'summary_en' => 'High-efficiency bifacial module for large rooftop and ground-mount plants.',
                'summary_ar' => 'لوح ثنائي الوجه عالي الكفاءة لمحطات الأسطح والأرضيات الكبيرة.',
                'desc_en' => "A high-efficiency **bifacial** module built for hot climates and high yield.\n\n- Tier-1 manufacturer\n- 1500V system voltage\n- Low light performance",
                'desc_ar' => "لوح **ثنائي الوجه** عالي الكفاءة مصمَّم للمناخ الحار والإنتاج العالي.\n\n- مصنّع من الفئة الأولى\n- جهد نظام 1500 فولت\n- أداء ممتاز في الإضاءة المنخفضة",
                'tags' => ['Tier-1', '1500V', 'Bifacial'],
                'specs' => [
                    ['label_en' => 'Power', 'label_ar' => 'القدرة', 'value' => '580 W'],
                    ['label_en' => 'Cell type', 'label_ar' => 'نوع الخلية', 'value' => 'Mono PERC'],
                    ['label_en' => 'Warranty', 'label_ar' => 'الضمان', 'value' => '25y'],
                ],
            ],
            [
                'cat' => 'inverters', 'featured' => true,
                'name_en' => 'On-Grid String Inverter 50kW', 'name_ar' => 'إنفرتر سترينج متصل بالشبكة 50 كيلوواط',
                'summary_en' => 'Three-phase grid-tied inverter for commercial and industrial plants.',
                'summary_ar' => 'إنفرتر ثلاثي الأطوار متصل بالشبكة للمنشآت التجارية والصناعية.',
                'desc_en' => "Reliable **three-phase** string inverter for C&I rooftops.\n\n- 4 MPPT trackers\n- High efficiency\n- Smart monitoring",
                'desc_ar' => "إنفرتر سترينج **ثلاثي الأطوار** موثوق لأسطح المنشآت التجارية والصناعية.\n\n- 4 متتبعات MPPT\n- كفاءة عالية\n- مراقبة ذكية",
                'tags' => ['On-grid', '3-phase'],
                'specs' => [
                    ['label_en' => 'Power', 'label_ar' => 'القدرة', 'value' => '50 kW'],
                    ['label_en' => 'MPPT', 'label_ar' => 'MPPT', 'value' => '4'],
                    ['label_en' => 'Phase', 'label_ar' => 'الأطوار', 'value' => '3'],
                ],
            ],
            [
                'cat' => 'inverters', 'featured' => false,
                'name_en' => 'Hybrid Inverter 8kW', 'name_ar' => 'إنفرتر هايبرد 8 كيلوواط',
                'summary_en' => 'Storage-ready hybrid inverter for homes and small businesses.',
                'summary_ar' => 'إنفرتر هايبرد جاهز للتخزين للمنازل والمشاريع الصغيرة.',
                'desc_en' => "Hybrid inverter with battery support for backup and self-consumption.",
                'desc_ar' => "إنفرتر هايبرد بدعم البطاريات للطاقة الاحتياطية والاستهلاك الذاتي.",
                'tags' => ['Hybrid', 'Storage-ready'],
                'specs' => [
                    ['label_en' => 'Power', 'label_ar' => 'القدرة', 'value' => '8 kW'],
                    ['label_en' => 'Battery', 'label_ar' => 'البطارية', 'value' => '48 V'],
                ],
            ],
            [
                'cat' => 'combiner-boxes', 'featured' => false,
                'name_en' => 'PV Combiner Box 6-String', 'name_ar' => 'صندوق تجميع 6 سلاسل',
                'summary_en' => 'Weatherproof DC combiner with surge and fuse protection.',
                'summary_ar' => 'صندوق تجميع DC مقاوم للعوامل الجوية بحماية ضد الصواعق والفيوزات.',
                'desc_en' => "IP65 combiner box with **surge protection** and DC fuses for safe string aggregation.",
                'desc_ar' => "صندوق تجميع IP65 بـ**حماية ضد الصواعق** وفيوزات DC لتجميع السلاسل بأمان.",
                'tags' => ['1000V', 'IP65'],
                'specs' => [
                    ['label_en' => 'Strings', 'label_ar' => 'السلاسل', 'value' => '6'],
                    ['label_en' => 'Protection', 'label_ar' => 'الحماية', 'value' => 'IP65'],
                ],
            ],
            [
                'cat' => 'cables-connectors', 'featured' => false,
                'name_en' => 'Solar DC Cable 6mm²', 'name_ar' => 'كابل شمسي DC مقاس 6 مم²',
                'summary_en' => 'Double-insulated, UV-resistant solar cable rated for 1500V.',
                'summary_ar' => 'كابل شمسي بعزل مزدوج ومقاوم للأشعة فوق البنفسجية بجهد 1500 فولت.',
                'desc_en' => "TUV-certified DC cable for long-life solar installations.",
                'desc_ar' => "كابل DC معتمد من TUV لتركيبات شمسية طويلة العمر.",
                'tags' => ['1500V', 'TUV'],
                'specs' => [
                    ['label_en' => 'Section', 'label_ar' => 'المقطع', 'value' => '6 mm²'],
                    ['label_en' => 'Rating', 'label_ar' => 'الجهد', 'value' => '1500 V'],
                ],
            ],
            [
                'cat' => 'cables-connectors', 'featured' => false,
                'name_en' => 'MC4 Connector Pair', 'name_ar' => 'زوج موصلات MC4',
                'summary_en' => 'IP68 male/female connectors for secure module connections.',
                'summary_ar' => 'موصلات IP68 (ذكر/أنثى) لتوصيلات ألواح آمنة.',
                'desc_en' => "Waterproof IP68 connectors with low contact resistance.",
                'desc_ar' => "موصلات IP68 مقاومة للماء بمقاومة تماس منخفضة.",
                'tags' => ['IP68'],
                'specs' => [
                    ['label_en' => 'Current', 'label_ar' => 'التيار', 'value' => '30 A'],
                ],
            ],
            [
                'cat' => 'circuit-breakers', 'featured' => false,
                'name_en' => 'DC Circuit Breaker 1000V', 'name_ar' => 'قاطع كهرباء DC بجهد 1000 فولت',
                'summary_en' => 'Two-pole DC breaker for solar array protection and isolation.',
                'summary_ar' => 'قاطع DC ثنائي القطب لحماية وعزل مصفوفة الألواح.',
                'desc_en' => "Reliable DC isolation and overcurrent protection for PV strings.",
                'desc_ar' => "عزل DC موثوق وحماية من التيار الزائد لسلاسل الألواح.",
                'tags' => ['1000V', '2-pole'],
                'specs' => [
                    ['label_en' => 'Voltage', 'label_ar' => 'الجهد', 'value' => '1000 V'],
                    ['label_en' => 'Poles', 'label_ar' => 'الأقطاب', 'value' => '2'],
                ],
            ],
            [
                'cat' => 'water-pumping', 'featured' => true,
                'name_en' => 'Submersible Solar Well Pump 7.5HP', 'name_ar' => 'مضخة آبار غاطسة بالطاقة الشمسية 7.5 حصان',
                'summary_en' => 'Solar-powered submersible pump for deep wells and irrigation.',
                'summary_ar' => 'مضخة غاطسة تعمل بالطاقة الشمسية للآبار العميقة والري.',
                'desc_en' => "High-head submersible pump driven directly by solar — ideal for farms and wells (abar).\n\n- No diesel, near-zero running cost\n- Built for deep wells",
                'desc_ar' => "مضخة غاطسة برفع عالٍ تعمل مباشرة بالطاقة الشمسية — مثالية للمزارع والآبار.\n\n- بدون ديزل، تكلفة تشغيل شبه معدومة\n- مصمّمة للآبار العميقة",
                'tags' => ['Agricultural', 'Solar DC'],
                'specs' => [
                    ['label_en' => 'Power', 'label_ar' => 'القدرة', 'value' => '7.5 HP'],
                    ['label_en' => 'Max head', 'label_ar' => 'أقصى ارتفاع', 'value' => '120 m'],
                ],
            ],
            [
                'cat' => 'water-pumping', 'featured' => false,
                'name_en' => 'UPVC Riser Pipe 4"', 'name_ar' => 'ماسورة صاعدة UPVC مقاس 4 بوصة',
                'summary_en' => 'Corrosion-free UPVC column pipe for submersible pump risers.',
                'summary_ar' => 'ماسورة UPVC مقاومة للتآكل لمواسير صعود المضخات الغاطسة.',
                'desc_en' => "Lightweight, corrosion-free UPVC riser pipe — a durable alternative to steel.",
                'desc_ar' => "ماسورة UPVC خفيفة ومقاومة للتآكل — بديل متين للصلب.",
                'tags' => ['UPVC'],
                'specs' => [
                    ['label_en' => 'Diameter', 'label_ar' => 'القطر', 'value' => '4 in'],
                    ['label_en' => 'Pressure', 'label_ar' => 'الضغط', 'value' => 'PN16'],
                ],
            ],
        ];

        $order = 1;
        foreach ($products as $p) {
            Product::updateOrCreate(
                ['slug' => Str::slug($p['name_en'])],
                [
                    'product_category_id' => $cat[$p['cat']] ?? null,
                    'name_en' => $p['name_en'],
                    'name_ar' => $p['name_ar'],
                    'summary_en' => $p['summary_en'],
                    'summary_ar' => $p['summary_ar'],
                    'description_en' => $p['desc_en'],
                    'description_ar' => $p['desc_ar'],
                    'tags' => $p['tags'],
                    'specs' => $p['specs'],
                    'status' => 'published',
                    'featured' => $p['featured'],
                    'sort_order' => $order++,
                ],
            );
        }
    }
}
