<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import { Head } from '@inertiajs/vue3';
import { site } from '@/lib/site';

const facts = [
    { k: 'Experience', v: `${site.yearsExperience} years` },
    { k: 'Headquarters', v: 'Sadat City, Egypt' },
    { k: 'Sectors', v: 'Industry · Agriculture · Commercial' },
    { k: 'Scope', v: 'Import · Supply · Install' },
    { k: 'Focus', v: 'Reliability & ROI' },
];
const pillars = [
    { title: 'Quality', text: 'High-grade components and precise engineering on every project.' },
    { title: 'Reliability', text: 'Consistent performance for years, backed by responsive support.' },
    { title: 'Value', text: 'Choices driven by your return on investment, not just price.' },
    { title: 'Partnership', text: 'A lasting relationship, from consultation through operation.' },
];
const traits = ['Trusted', 'Knowledgeable', 'Transparent', 'Reliable', 'Forward-Thinking'];
</script>

<template>
    <Head title="About Us — Metanoia Energy">
        <meta name="description" content="Learn about Metanoia Energy: an Egyptian solar company with 6+ years of experience delivering integrated solar solutions built on quality, reliability, value, and partnership." />
    </Head>

    <PublicLayout>
        <!-- HERO -->
        <section class="relative overflow-hidden bg-brand-beige/50">
            <div class="container-x max-w-3xl py-16 lg:py-20">
                <p class="eyebrow">About Metanoia</p>
                <h1 class="mt-5 font-display text-4xl font-extrabold leading-[1.1] tracking-tight text-brand-blue lg:text-[3rem]">
                    A trusted partner in the solar transition
                </h1>
                <p class="lead mt-6">
                    Metanoia Energy is an Egyptian solar company delivering integrated solar power solutions for
                    factories, farms, and commercial facilities — built on engineering precision, quality, and a
                    genuine commitment to long-term results.
                </p>
            </div>
        </section>

        <!-- WHO WE ARE -->
        <section class="section">
            <div class="container-x grid items-start gap-12 lg:grid-cols-[1.3fr_0.7fr] lg:gap-16">
                <div>
                    <p class="eyebrow">Who We Are</p>
                    <h2 class="heading mt-4">Solar, treated as an investment — not a product</h2>
                    <div class="lead mt-6 space-y-5">
                        <p>With more than <strong class="text-brand-navy">{{ site.yearsExperience }} years</strong> of hands-on experience, Metanoia Energy imports, supplies, and installs complete solar systems of every type — engineered to rigorous standards and high quality benchmarks.</p>
                        <p>We focus on the sectors where solar makes the biggest difference: industrial, agricultural, and commercial facilities looking to cut operating costs and secure a sustainable, long-term return.</p>
                        <p>In a crowded market, we compete on something different — trust, reliability, and real value. We don't just sell equipment; we help our clients make confident decisions and stand beside them long after the system goes live.</p>
                    </div>
                </div>
                <div class="flex flex-col gap-6">
                    <img src="/images/about-art.svg" alt="Solar panels under a clear sky" class="w-full rounded-[20px] ring-1 ring-brand-border" />
                    <aside class="card-b">
                        <h3 class="font-display text-lg font-bold text-brand-blue">At a glance</h3>
                        <dl class="mt-5 space-y-4">
                            <div v-for="(f, i) in facts" :key="f.k" class="flex justify-between gap-4 pb-4" :class="i < facts.length - 1 ? 'border-b border-brand-border' : ''">
                                <dt class="text-sm text-brand-muted">{{ f.k }}</dt>
                                <dd class="text-right font-display font-semibold">{{ f.v }}</dd>
                            </div>
                        </dl>
                    </aside>
                </div>
            </div>
        </section>

        <!-- VISION / MISSION -->
        <section class="section pt-0">
            <div class="container-x grid gap-6 md:grid-cols-2">
                <article class="card-b card-b--blue">
                    <h3 class="font-display text-xl font-bold text-brand-blue">Our Vision</h3>
                    <p class="mt-2 leading-relaxed text-brand-muted">To become the most trusted partner for solar energy solutions in Egypt and the Middle East — leading the transition to a more efficient, sustainable future through the highest standards of quality and reliability.</p>
                </article>
                <article class="card-b card-b--navy">
                    <h3 class="font-display text-xl font-bold text-white">Our Mission</h3>
                    <p class="mt-2 leading-relaxed text-brand-beige/80">To enable our clients to transition to a more efficient, sustainable future through reliable, high-quality solar solutions — built on transparency and an unwavering commitment to results.</p>
                </article>
            </div>
        </section>

        <!-- PILLARS -->
        <section class="section pt-0">
            <div class="container-x">
                <div class="max-w-2xl">
                    <p class="eyebrow">What We Stand On</p>
                    <h2 class="heading mt-4">Four pillars behind every project</h2>
                </div>
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <article v-for="p in pillars" :key="p.title" class="card-b">
                        <h3 class="font-display text-xl font-bold text-brand-blue">{{ p.title }}</h3>
                        <p class="mt-2 text-[0.975rem] leading-relaxed text-brand-muted">{{ p.text }}</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- PERSONALITY -->
        <section class="section pt-0">
            <div class="container-x">
                <div class="rounded-[28px] bg-brand-beige px-7 py-12 md:px-12">
                    <p class="eyebrow">How We Show Up</p>
                    <h2 class="heading mt-4 max-w-2xl">Confident, clear, and genuinely helpful</h2>
                    <p class="lead mt-4 max-w-2xl">We simplify the technical, lead with evidence, and communicate like a partner — never a salesperson.</p>
                    <ul class="mt-8 flex flex-wrap gap-3">
                        <li v-for="t in traits" :key="t" class="rounded-full border border-brand-border bg-white px-5 py-2 font-display text-sm font-semibold text-brand-blue">{{ t }}</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- FOUNDER -->
        <section class="section pt-0">
            <div class="container-x">
                <div class="grid items-center gap-8 rounded-[28px] bg-brand-navy p-8 text-brand-beige md:grid-cols-[auto_1fr] md:gap-12 md:p-12">
                    <div class="flex shrink-0 flex-col items-center text-center">
                        <span class="inline-flex h-28 w-28 items-center justify-center rounded-full bg-brand-yellow/15 text-brand-yellow ring-1 ring-brand-yellow/30">
                            <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4" /><path d="M4 21a8 8 0 0 1 16 0" /></svg>
                        </span>
                        <p class="mt-4 font-display text-lg font-bold text-white">{{ site.founderName }}</p>
                        <p class="text-sm font-medium text-brand-yellow">{{ site.founderRole }}</p>
                    </div>
                    <div>
                        <p class="eyebrow eyebrow--gold">A message from our founder</p>
                        <blockquote class="mt-5 font-display text-xl leading-relaxed text-white md:text-2xl">
                            "Solar energy isn't just equipment you install — it's an investment that deserves a partner
                            you can trust to deliver real, lasting results. That belief is why we built Metanoia."
                        </blockquote>
                    </div>
                </div>
            </div>
        </section>

        <CtaSection />
    </PublicLayout>
</template>
