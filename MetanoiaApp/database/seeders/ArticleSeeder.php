<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $pairs = [
            [
                'group' => 'on-grid-vs-off-grid',
                'days_ago' => 3,
                'en' => [
                    'slug' => 'on-grid-vs-off-grid-solar-which-is-right-for-your-facility',
                    'category' => 'Guides',
                    'title' => 'On-Grid vs. Off-Grid Solar: Which Is Right for Your Facility?',
                    'excerpt' => 'A practical breakdown of grid-tied and standalone solar systems — and how to choose based on your load, location, and return on investment.',
                    'body' => <<<'MD'
Choosing between on-grid and off-grid solar is one of the first decisions every factory, farm, or commercial facility faces. The right answer depends less on the technology itself and more on **how you use energy** and **what the grid looks like at your site**.

## On-grid systems

On-grid (grid-tied) systems run in parallel with the public electricity network.

- **Lowest cost per kilowatt** — no battery bank required.
- **Fast payback** — every kilowatt-hour you generate offsets one you'd buy.
- **Best for high daytime consumption.**

## Off-grid systems

Off-grid systems operate independently, storing energy in batteries.

- **Energy independence** — ideal where the grid is weak or absent.
- **Higher upfront cost** — storage adds to the bill.
- **Best for remote farms and pumping stations.**

> If you have a stable grid connection and consume most of your power during the day, on-grid almost always delivers the strongest ROI.

At Metanoia, we start every project with a consumption and site study, then model the payback for each option before you commit.
MD,
                ],
                'ar' => [
                    'slug' => 'on-grid-vs-off-grid-solar-ar',
                    'category' => 'أدلة',
                    'title' => 'أنظمة متصلة بالشبكة أم مستقلة عنها: أنهي الأنسب لمنشأتك؟',
                    'excerpt' => 'شرح عملي للفرق بين الأنظمة المتصلة بالشبكة والمستقلة عنها — وإزاي تختار حسب أحمالك وموقعك وعائد استثمارك.',
                    'body' => <<<'MD'
الاختيار بين النظام المتصل بالشبكة والمستقل عنها من أول القرارات اللي بيواجهها أي مصنع أو مزرعة أو منشأة تجارية. والإجابة الصح بتعتمد على **طريقة استهلاكك للطاقة** و**شكل الشبكة في موقعك** أكتر من التقنية نفسها.

## الأنظمة المتصلة بالشبكة

النظام المتصل بالشبكة بيشتغل بالتوازي مع شبكة الكهرباء العامة.

- **أقل تكلفة لكل كيلوواط** — من غير بطاريات.
- **استرداد سريع** — كل كيلوواط/ساعة بتنتجه بيوفّر واحد كنت هتشتريه.
- **الأنسب للاستهلاك العالي نهارًا.**

## الأنظمة المستقلة عن الشبكة

النظام المستقل بيشتغل لوحده، وبيخزّن الطاقة في بطاريات.

- **استقلال في الطاقة** — مثالي لما تكون الشبكة ضعيفة أو مش موجودة.
- **تكلفة مبدئية أعلى** — التخزين بيزوّد الفاتورة.
- **الأنسب للمزارع البعيدة ومحطات الضخ.**

> لو عندك اتصال مستقر بالشبكة وبتستهلك أغلب طاقتك بالنهار، النظام المتصل بالشبكة بيحقّق أقوى عائد في الغالب.

في ميتانويا، بنبدأ كل مشروع بدراسة للاستهلاك والموقع، وبعدين بنحسب فترة الاسترداد لكل خيار قبل ما تلتزم.
MD,
                ],
            ],
            [
                'group' => 'egyptian-factories',
                'days_ago' => 9,
                'en' => [
                    'slug' => 'how-egyptian-factories-are-cutting-energy-costs-with-solar',
                    'category' => 'Industry',
                    'title' => 'How Egyptian Factories Are Cutting Energy Costs With Solar',
                    'excerpt' => 'Rising tariffs are reshaping industrial economics. Here is how solar is helping Egyptian manufacturers protect their margins.',
                    'body' => <<<'MD'
Electricity is one of the largest controllable costs on a factory floor — and as tariffs climb, it's the difference between a healthy margin and a squeezed one.

## The shift in industrial economics

Manufacturers are turning to solar as a **financial decision**:

1. **Predictable costs** for 25+ years.
2. **OPEX relief** straight to the bottom line.
3. **Strong, measurable ROI.**

> We don't sell panels. We help you make a sound, long-term investment — and stay with you long after the system is switched on.
MD,
                ],
                'ar' => [
                    'slug' => 'egyptian-factories-energy-costs-ar',
                    'category' => 'القطاع',
                    'title' => 'إزاي المصانع المصرية بتقلّل تكاليف الطاقة بالطاقة الشمسية',
                    'excerpt' => 'ارتفاع التعريفة بيعيد تشكيل اقتصاديات الصناعة. ده إزاي الطاقة الشمسية بتساعد المصنّعين المصريين يحموا هوامش أرباحهم.',
                    'body' => <<<'MD'
الكهرباء من أكبر التكاليف اللي تقدر تتحكم فيها جوه المصنع — ومع ارتفاع التعريفة، بقت هي الفرق بين هامش ربح صحي وهامش مضغوط.

## تحوّل في اقتصاديات الصناعة

المصنّعين بيتجهوا للطاقة الشمسية كـ**قرار مالي**:

1. **تكاليف متوقّعة** لأكتر من 25 سنة.
2. **تخفيف لمصاريف التشغيل** بيروح مباشرة لصافي الربح.
3. **عائد قوي وقابل للقياس.**

> إحنا مابنبيعش ألواح. بنساعدك تاخد قرار استثماري سليم وطويل المدى — وبنفضل معاك بعد تشغيل النظام بكتير.
MD,
                ],
            ],
            [
                'group' => 'solar-pumping-farms',
                'days_ago' => 16,
                'en' => [
                    'slug' => 'solar-pumping-for-farms-lower-fuel-bills-season-after-season',
                    'category' => 'Guides',
                    'title' => 'Solar Pumping for Farms: Lower Fuel Bills, Season After Season',
                    'excerpt' => 'Diesel pumping is expensive and unpredictable. Solar pumping delivers reliable irrigation with almost no running cost.',
                    'body' => <<<'MD'
For farms, irrigation is non-negotiable — and diesel pumping is one of the biggest and most volatile costs of the season.

## Why solar pumping makes sense

- **Near-zero running cost.** The sun does the work.
- **Reliable through the season.**
- **Lower maintenance** than a diesel generator.

> Reliable water, predictable costs, and a system that keeps paying you back every season.
MD,
                ],
                'ar' => [
                    'slug' => 'solar-pumping-for-farms-ar',
                    'category' => 'أدلة',
                    'title' => 'الضخ بالطاقة الشمسية للمزارع: فاتورة وقود أقل، موسم ورا موسم',
                    'excerpt' => 'الضخ بالديزل غالي وغير متوقّع. الضخ بالطاقة الشمسية بيوفّر ري موثوق بتكلفة تشغيل شبه معدومة.',
                    'body' => <<<'MD'
بالنسبة للمزارع، الري حاجة مفيش غنى عنها — والضخ بالديزل من أكبر تكاليف الموسم وأكترها تقلّبًا.

## ليه الضخ بالطاقة الشمسية منطقي

- **تكلفة تشغيل شبه معدومة.** الشمس بتعمل الشغل.
- **موثوق طول الموسم.**
- **صيانة أقل** من مولّد الديزل.

> مياه موثوقة، وتكاليف متوقّعة، ونظام بيرجّعلك قيمته كل موسم.
MD,
                ],
            ],
            [
                'group' => 'think-beyond-energy-roi',
                'days_ago' => 24,
                'en' => [
                    'slug' => 'think-beyond-energy-why-roi-beats-the-lowest-price',
                    'category' => 'Company News',
                    'title' => 'Think Beyond Energy: Why ROI Beats the Lowest Price',
                    'excerpt' => 'The cheapest quote is rarely the best investment. Here is how we evaluate solar projects on return, not just sticker price.',
                    'body' => <<<'MD'
It's tempting to choose a solar system on price alone. But a solar plant is a **25-year investment**, and the cheapest components often cost far more over their lifetime.

## What actually drives return

- **Component quality.**
- **Engineering precision.**
- **After-sales support.**

> Think beyond energy: a solar system should be measured by what it returns, not just what it costs.
MD,
                ],
                'ar' => [
                    'slug' => 'think-beyond-energy-roi-ar',
                    'category' => 'أخبار الشركة',
                    'title' => 'فكّر أبعد من الطاقة: ليه العائد أهم من أرخص سعر',
                    'excerpt' => 'أرخص عرض نادرًا ما يكون أفضل استثمار. ده إزاي بنقيّم مشاريع الطاقة الشمسية على العائد، مش بس السعر المبدئي.',
                    'body' => <<<'MD'
من المغري إنك تختار النظام الشمسي على أساس السعر بس. لكن المحطة الشمسية **استثمار لـ25 سنة**، وأرخص المكوّنات غالبًا بتكلّفك أكتر بكتير على مدى عمرها.

## اللي بيحرّك العائد فعلاً

- **جودة المكوّنات.**
- **دقة الهندسة.**
- **دعم ما بعد البيع.**

> فكّر أبعد من الطاقة: النظام الشمسي المفروض يتقاس بقيمته اللي بيرجّعها، مش بس بتكلفته.
MD,
                ],
            ],
        ];

        foreach ($pairs as $pair) {
            // Stable, deterministic group id so re-seeding keeps the EN/AR link intact.
            $groupId = Uuid::uuid5(Uuid::NAMESPACE_URL, 'metanoia-article-'.$pair['group'])->toString();

            foreach (['en', 'ar'] as $locale) {
                $d = $pair[$locale];

                Article::updateOrCreate(
                    ['slug' => $d['slug']],
                    [
                        'locale' => $locale,
                        'group_id' => $groupId,
                        'title' => $d['title'],
                        'category' => $d['category'],
                        'excerpt' => $d['excerpt'],
                        'body' => $d['body'],
                        'author' => $locale === 'ar' ? 'ميتانويا للطاقة' : 'Metanoia Energy',
                        'status' => 'published',
                        'published_at' => now()->subDays($pair['days_ago']),
                    ]
                );
            }
        }
    }
}
