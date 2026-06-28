<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import { Head, Link } from '@inertiajs/vue3';
import { site } from '@/lib/site';

const solutions = [
    { title: 'On-Grid Solar Systems', accent: 'gold', text: 'Grid-tied systems that cut your electricity bill and stabilize operating costs — with fast payback for high-consumption facilities.', icon: '<path d="M4 4h16v6H4z"/><path d="M4 14h16v6H4z"/><path d="M8 10v4M16 10v4"/>' },
    { title: 'Off-Grid Solar Systems', accent: 'blue', text: 'Independent power with storage for sites where grid supply is limited, unreliable, or unavailable.', icon: '<rect x="2" y="7" width="16" height="10" rx="2"/><path d="M22 10v4"/><path d="M6 10v4"/>' },
    { title: 'Solar Pumping Systems', accent: 'gold', text: 'Reliable solar-powered pumping for irrigation and farms — lower fuel and electricity costs, season after season.', icon: '<path d="M12 2s6 6.5 6 11a6 6 0 0 1-12 0c0-4.5 6-11 6-11Z"/>' },
    { title: 'Plant Upgrades & Optimization', accent: 'blue', text: 'Assess, expand, and upgrade existing solar stations to recover lost output and improve efficiency.', icon: '<path d="M3 17l6-6 4 4 8-8"/><path d="M17 7h4v4"/>' },
    { title: 'Import & Supply', accent: 'gold', text: 'Sourcing and supplying high-quality, verified solar components you can rely on for the long term.', icon: '<path d="m3 7 9-4 9 4-9 4-9-4Z"/><path d="M3 7v10l9 4 9-4V7"/><path d="M12 11v10"/>' },
    { title: 'Engineering, Installation & Support', accent: 'navy', text: 'Precise engineering, professional installation, and ongoing technical support and after-sales care — one accountable partner, start to finish.', icon: '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4l-6 6 2 2 6-6a4 4 0 0 0 5.4-5.4l-2.3 2.3-2-2 2.3-2.3Z"/>' },
];

const sectors = [
    { title: 'Factories & Industry', text: 'Reduce electricity costs, stabilize OPEX, and protect margins with solar built for industrial loads.', icon: '<path d="M3 21V8l7-4v5l7-4v16Z"/><path d="M7 13h0M7 17h0M14 13h0M14 17h0"/>' },
    { title: 'Farms & Agriculture', text: 'Power irrigation and operations sustainably — cutting fuel and electricity costs across the season.', icon: '<path d="M12 22c4-2 7-6 7-11a7 7 0 0 0-14 0c0 5 3 9 7 11Z"/><path d="M12 22V9"/>' },
    { title: 'Commercial Facilities', text: 'Offices, malls, compounds, and service centers — cleaner, more predictable energy costs.', icon: '<path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/>' },
    { title: 'Contractors & EPC', text: 'A reliable supply and execution partner for contractors and installation companies.', icon: '<path d="M2 20h20"/><path d="m4 20 4-9 4 3 4-7 4 13"/>' },
];

const pillars = [
    { title: 'Quality', text: 'High-grade components and precise engineering standards on every single project.', icon: '<path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>' },
    { title: 'Reliability', text: 'Systems built to perform consistently for years, backed by responsive technical support.', icon: '<path d="M12 2 4 5v6c0 5 3.5 8.5 8 11 4.5-2.5 8-6 8-11V5Z"/>' },
    { title: 'Value', text: 'Decisions driven by your return on investment — not just the lowest price on the table.', icon: '<circle cx="12" cy="12" r="9"/><path d="M14.5 9.5A2.5 2.5 0 0 0 12 8c-1.4 0-2.5.9-2.5 2s1.1 2 2.5 2 2.5.9 2.5 2-1.1 2-2.5 2a2.5 2.5 0 0 1-2.5-1.5M12 6.5v11"/>' },
    { title: 'Partnership', text: 'A long-term relationship — from first consultation through operation and beyond.', icon: '<path d="M16 18a4 4 0 0 0-8 0"/><circle cx="12" cy="8" r="4"/><path d="M3 20a6 6 0 0 1 6-5M21 20a6 6 0 0 0-6-5"/>' },
];

const steps = [
    { num: '01', title: 'Consult & Assess', text: 'We study your consumption, site, and goals.' },
    { num: '02', title: 'Design & ROI Study', text: 'We model the savings and payback before you commit.' },
    { num: '03', title: 'Supply', text: 'We source verified, high-quality components.' },
    { num: '04', title: 'Install', text: 'Professional engineering and installation on site.' },
    { num: '05', title: 'Operate & Support', text: 'Ongoing monitoring, maintenance, and after-sales care.' },
];

const iconWrap = (accent: string) =>
    accent === 'navy' ? 'bg-brand-yellow/15 text-brand-yellow' : 'bg-brand-blue/10 text-brand-blue';
const titleColor = (accent: string) => (accent === 'navy' ? 'text-white' : 'text-brand-blue');
const textColor = (accent: string) => (accent === 'navy' ? 'text-brand-beige/80' : 'text-brand-muted');
</script>

<template>
    <Head title="Metanoia Energy — Integrated Solar Solutions for Factories, Farms & Business">
        <meta name="description" content="Metanoia Energy is your trusted partner in the solar transition — integrated, high-quality solar systems engineered for performance, reliability, and real return on investment in Egypt." />
    </Head>

    <PublicLayout>
        <!-- HERO -->
        <section class="relative overflow-hidden">
            <img src="/images/hero-art.svg" alt="Solar panels at sunrise" class="absolute inset-0 h-full w-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-navy/90 via-brand-navy/70 to-brand-navy/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-brand-navy/55 to-transparent"></div>

            <div class="container-x relative flex min-h-[78vh] items-center py-20 lg:py-28">
                <div class="max-w-2xl">
                    <p class="eyebrow eyebrow--gold">Think Beyond Energy</p>
                    <h1 class="mt-5 font-display text-[2.5rem] font-extrabold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-[3.6rem]">
                        Reliable solar power for factories, farms &amp; businesses.
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-brand-beige/90">
                        Metanoia Energy is your trusted partner in the solar transition — integrated, high-quality
                        systems engineered for performance, reliability, and a return you can actually measure.
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <Link href="/quote" class="btn btn--primary">Get a Free Quote</Link>
                        <a href="#solutions" class="btn btn--outline-light">Explore Our Solutions</a>
                    </div>
                    <ul class="mt-10 flex flex-wrap gap-x-7 gap-y-3 text-sm text-brand-beige/90">
                        <li v-for="t in [`${site.yearsExperience} years of experience`, 'Quality components', 'End-to-end delivery']" :key="t" class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-brand-yellow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5" /></svg>
                            {{ t }}
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- STATS -->
        <section class="bg-brand-navy">
            <div class="container-x py-14">
                <div class="grid grid-cols-2 gap-x-6 gap-y-10 text-center lg:grid-cols-4">
                    <div v-for="s in [{ n: site.yearsExperience, l: 'Years of solar experience' }, { n: '3', l: 'Core sectors: industry, agriculture & commercial' }, { n: 'End-to-End', l: 'Import · supply · installation' }, { n: 'ROI First', l: 'Built as an investment, not a purchase' }]" :key="s.l">
                        <p class="font-display text-[clamp(2rem,4vw,2.75rem)] font-extrabold leading-none text-white">{{ s.n }}</p>
                        <p class="mt-2 text-[0.95rem] text-brand-beige/72">{{ s.l }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SOLUTIONS -->
        <section id="solutions" class="section">
            <div class="container-x">
                <div class="max-w-2xl">
                    <p class="eyebrow">Our Solutions</p>
                    <h2 class="heading mt-4">Integrated solar, engineered end-to-end</h2>
                    <p class="lead mt-4">From the first feasibility study to long-term operation, we design and deliver complete solar systems tailored to how you actually use energy.</p>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <article v-for="s in solutions" :key="s.title" class="card-b hover:-translate-y-[3px]" :class="{ 'card-b--gold': s.accent === 'gold', 'card-b--blue': s.accent === 'blue', 'card-b--navy': s.accent === 'navy' }">
                        <span class="mb-[1.15rem] inline-flex h-[52px] w-[52px] items-center justify-center rounded-[14px]" :class="iconWrap(s.accent)">
                            <svg class="h-[26px] w-[26px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" v-html="s.icon" />
                        </span>
                        <h3 class="font-display text-xl font-bold" :class="titleColor(s.accent)">{{ s.title }}</h3>
                        <p class="mt-2 text-[0.975rem] leading-relaxed" :class="textColor(s.accent)">{{ s.text }}</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- SECTORS -->
        <section id="sectors" class="section pt-0">
            <div class="container-x">
                <div class="max-w-2xl">
                    <p class="eyebrow">Who We Serve</p>
                    <h2 class="heading mt-4">Built for the sectors that run on energy</h2>
                    <p class="lead mt-4">We focus on the facilities where solar delivers the highest value and the strongest return — and we speak each sector's language.</p>
                </div>
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <article v-for="s in sectors" :key="s.title" class="card-b hover:-translate-y-[3px]">
                        <span class="mb-[1.15rem] inline-flex h-[52px] w-[52px] items-center justify-center rounded-[14px] bg-brand-blue/10 text-brand-blue">
                            <svg class="h-[26px] w-[26px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" v-html="s.icon" />
                        </span>
                        <h3 class="font-display text-xl font-bold text-brand-blue">{{ s.title }}</h3>
                        <p class="mt-2 text-[0.975rem] leading-relaxed text-brand-muted">{{ s.text }}</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- WHY -->
        <section id="why" class="section bg-brand-beige">
            <div class="container-x grid items-start gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">
                <div class="lg:sticky lg:top-28">
                    <p class="eyebrow">Why Metanoia</p>
                    <h2 class="heading mt-4">A partner, not just a supplier</h2>
                    <p class="lead mt-4">Most companies sell you panels. We help you make a sound, long-term investment — and we stay with you long after the system is switched on. It's the difference between a transaction and a partnership.</p>
                    <Link href="/about" class="btn btn--primary mt-7">More about us</Link>
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <article v-for="p in pillars" :key="p.title" class="card-b hover:-translate-y-[3px]">
                        <span class="mb-[1.15rem] inline-flex h-[52px] w-[52px] items-center justify-center rounded-[14px] bg-brand-blue/10 text-brand-blue">
                            <svg class="h-[26px] w-[26px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" v-html="p.icon" />
                        </span>
                        <h3 class="font-display text-xl font-bold text-brand-blue">{{ p.title }}</h3>
                        <p class="mt-2 text-[0.975rem] leading-relaxed text-brand-muted">{{ p.text }}</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- PROCESS -->
        <section class="section">
            <div class="container-x">
                <div class="max-w-2xl">
                    <p class="eyebrow">How We Work</p>
                    <h2 class="heading mt-4">From consultation to long-term operation</h2>
                    <p class="lead mt-4">A clear, accountable process — so you always know what happens next.</p>
                </div>
                <ol class="mt-12 grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-5">
                    <li v-for="st in steps" :key="st.num">
                        <p class="font-display text-[0.9rem] font-extrabold tracking-eyebrow text-brand-yellow">{{ st.num }}</p>
                        <h3 class="mt-1.5 font-display font-bold text-brand-blue">{{ st.title }}</h3>
                        <p class="mt-1 text-[0.95rem] leading-relaxed text-brand-muted">{{ st.text }}</p>
                    </li>
                </ol>
            </div>
        </section>

        <CtaSection />
    </PublicLayout>
</template>
