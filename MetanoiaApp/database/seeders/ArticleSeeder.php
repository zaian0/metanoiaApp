<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'On-Grid vs. Off-Grid Solar: Which Is Right for Your Facility?',
                'category' => 'Guides',
                'excerpt' => 'A practical breakdown of grid-tied and standalone solar systems — and how to choose based on your load, location, and return on investment.',
                'days_ago' => 3,
                'read' => 6,
                'body' => <<<'MD'
Choosing between on-grid and off-grid solar is one of the first decisions every factory, farm, or commercial facility faces. The right answer depends less on the technology itself and more on **how you use energy** and **what the grid looks like at your site**.

## On-grid systems

On-grid (grid-tied) systems run in parallel with the public electricity network. They're the most common choice for facilities that already have a reliable connection.

- **Lowest cost per kilowatt** — no battery bank required.
- **Fast payback** — every kilowatt-hour you generate offsets a kilowatt-hour you'd otherwise buy.
- **Best for high daytime consumption** — factories and commercial buildings that run during sunlight hours benefit most.

## Off-grid systems

Off-grid systems operate independently, storing energy in batteries for use at night or during outages.

- **Energy independence** — ideal where the grid is weak, unreliable, or absent.
- **Higher upfront cost** — storage adds to the bill, but removes exposure to outages and fuel.
- **Best for remote farms and pumping stations.**

## How to decide

> If you have a stable grid connection and consume most of your power during the day, on-grid almost always delivers the strongest ROI.

For sites with frequent outages or no grid access, off-grid — or a hybrid system — protects operations and replaces expensive diesel.

At Metanoia, we start every project with a consumption and site study, then model the payback for each option **before** you commit to anything.
MD,
            ],
            [
                'title' => 'How Egyptian Factories Are Cutting Energy Costs With Solar',
                'category' => 'Industry',
                'excerpt' => 'Rising tariffs are reshaping industrial economics. Here is how solar is helping Egyptian manufacturers protect their margins.',
                'days_ago' => 9,
                'read' => 5,
                'body' => <<<'MD'
Electricity is one of the largest controllable costs on a factory floor — and as tariffs climb, it's increasingly the difference between a healthy margin and a squeezed one.

## The shift in industrial economics

Energy-intensive manufacturers are turning to solar not as an environmental gesture, but as a **financial decision**:

1. **Predictable costs.** Solar locks in a large share of your energy spend for 25+ years.
2. **OPEX relief.** Lower monthly bills flow straight to the bottom line.
3. **Strong, measurable ROI.** Most industrial rooftops pay back in a handful of years and generate for decades after.

## What makes industrial solar different

Factories have large, consistent daytime loads and significant roof or land area — the ideal profile for solar. The engineering, however, has to respect:

- Three-phase industrial connections and load balancing
- Roof structure and safety
- Production uptime during installation

## Built as an investment

> We don't sell panels. We help you make a sound, long-term investment — and stay with you long after the system is switched on.

That's the difference between a transaction and a partnership — and it's why we model the savings and payback before a single panel is ordered.
MD,
            ],
            [
                'title' => 'Solar Pumping for Farms: Lower Fuel Bills, Season After Season',
                'category' => 'Guides',
                'excerpt' => 'Diesel pumping is expensive and unpredictable. Solar pumping delivers reliable irrigation with almost no running cost.',
                'days_ago' => 16,
                'read' => 4,
                'body' => <<<'MD'
For farms, irrigation is non-negotiable — and for many, diesel pumping is one of the biggest and most volatile costs of the season.

## Why solar pumping makes sense

- **Near-zero running cost.** Once installed, the sun does the work — no fuel, no fuel logistics.
- **Reliable through the season.** Pumping aligns naturally with daylight and peak irrigation needs.
- **Lower maintenance.** Fewer moving parts than a diesel generator and pump.

## What we assess first

Every farm is different, so we study:

1. Water source depth and flow requirements
2. Daily irrigation volume and timing
3. Land and mounting options

From there we size a system that meets your peak demand and model the payback against your current fuel spend.

> The goal is simple: reliable water, predictable costs, and a system that keeps paying you back every season.
MD,
            ],
            [
                'title' => 'Think Beyond Energy: Why ROI Beats the Lowest Price',
                'category' => 'Company News',
                'excerpt' => 'The cheapest quote is rarely the best investment. Here is how we evaluate solar projects on return, not just sticker price.',
                'days_ago' => 24,
                'read' => 3,
                'body' => <<<'MD'
It's tempting to choose a solar system on price alone. But a solar plant isn't a one-time purchase — it's a **25-year investment**, and the cheapest components often cost far more over their lifetime.

## What actually drives return

- **Component quality.** Higher-grade panels and inverters degrade slower and fail less.
- **Engineering precision.** Correct sizing and installation protect output for decades.
- **After-sales support.** A system that's monitored and maintained keeps performing.

## Our approach

We make decisions driven by your **return on investment** — not just the lowest number on the table:

1. Study your real consumption and site
2. Model savings and payback transparently
3. Supply verified, high-quality components
4. Install with precision and support you long-term

> Think beyond energy: a solar system should be measured by what it returns, not just what it costs.
MD,
            ],
        ];

        foreach ($articles as $a) {
            Article::updateOrCreate(
                ['slug' => Str::slug($a['title'])],
                [
                    'title' => $a['title'],
                    'category' => $a['category'],
                    'excerpt' => $a['excerpt'],
                    'body' => $a['body'],
                    'author' => 'Metanoia Energy',
                    'status' => 'published',
                    'published_at' => now()->subDays($a['days_ago']),
                ]
            );
        }
    }
}
