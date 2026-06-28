<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import { useTranslations } from '@/composables/useTranslations';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const { t, tList, localePath } = useTranslations();

interface Item {
    title: string;
    text: string;
}

// Presentation (icons + accents) stays in code; copy comes from the lang files.
const solutionIcons = [
    '<path d="M4 4h16v6H4z"/><path d="M4 14h16v6H4z"/><path d="M8 10v4M16 10v4"/>',
    '<rect x="2" y="7" width="16" height="10" rx="2"/><path d="M22 10v4"/><path d="M6 10v4"/>',
    '<path d="M12 2s6 6.5 6 11a6 6 0 0 1-12 0c0-4.5 6-11 6-11Z"/>',
    '<path d="M3 17l6-6 4 4 8-8"/><path d="M17 7h4v4"/>',
    '<path d="m3 7 9-4 9 4-9 4-9-4Z"/><path d="M3 7v10l9 4 9-4V7"/><path d="M12 11v10"/>',
    '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4l-6 6 2 2 6-6a4 4 0 0 0 5.4-5.4l-2.3 2.3-2-2 2.3-2.3Z"/>',
];
const solutionAccents = ['gold', 'blue', 'gold', 'blue', 'gold', 'navy'];

const sectorIcons = [
    '<path d="M3 21V8l7-4v5l7-4v16Z"/><path d="M7 13h0M7 17h0M14 13h0M14 17h0"/>',
    '<path d="M12 22c4-2 7-6 7-11a7 7 0 0 0-14 0c0 5 3 9 7 11Z"/><path d="M12 22V9"/>',
    '<path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/>',
    '<path d="M2 20h20"/><path d="m4 20 4-9 4 3 4-7 4 13"/>',
];

const pillarIcons = [
    '<path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>',
    '<path d="M12 2 4 5v6c0 5 3.5 8.5 8 11 4.5-2.5 8-6 8-11V5Z"/>',
    '<circle cx="12" cy="12" r="9"/><path d="M14.5 9.5A2.5 2.5 0 0 0 12 8c-1.4 0-2.5.9-2.5 2s1.1 2 2.5 2 2.5.9 2.5 2-1.1 2-2.5 2a2.5 2.5 0 0 1-2.5-1.5M12 6.5v11"/>',
    '<path d="M16 18a4 4 0 0 0-8 0"/><circle cx="12" cy="8" r="4"/><path d="M3 20a6 6 0 0 1 6-5M21 20a6 6 0 0 0-6-5"/>',
];

const heroBadges = computed(() => tList<string>('home.hero.badges'));
const stats = computed(() => tList<{ n: string; l: string }>('home.stats'));
const solutions = computed(() =>
    tList<Item>('home.solutions.items').map((s, i) => ({ ...s, icon: solutionIcons[i], accent: solutionAccents[i] })),
);
const sectors = computed(() => tList<Item>('home.sectors.items').map((s, i) => ({ ...s, icon: sectorIcons[i] })));
const pillars = computed(() => tList<Item>('home.why.pillars').map((p, i) => ({ ...p, icon: pillarIcons[i] })));
const steps = computed(() =>
    tList<Item>('home.process.steps').map((s, i) => ({ ...s, num: String(i + 1).padStart(2, '0') })),
);

const iconWrap = (accent: string) =>
    accent === 'navy' ? 'bg-brand-yellow/15 text-brand-yellow' : 'bg-brand-blue/10 text-brand-blue';
const titleColor = (accent: string) => (accent === 'navy' ? 'text-white' : 'text-brand-blue');
const textColor = (accent: string) => (accent === 'navy' ? 'text-brand-beige/80' : 'text-brand-muted');
</script>

<template>
    <Head :title="t('home.meta_title')">
        <meta name="description" :content="t('home.meta_description')" />
    </Head>

    <PublicLayout>
        <!-- HERO -->
        <section class="relative overflow-hidden">
            <img src="/images/hero-art.svg" alt="" class="absolute inset-0 h-full w-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-navy/90 via-brand-navy/70 to-brand-navy/40 rtl:bg-gradient-to-l"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-brand-navy/55 to-transparent"></div>

            <div class="container-x relative flex min-h-[78vh] items-center py-20 lg:py-28">
                <div class="max-w-2xl">
                    <p class="eyebrow eyebrow--gold">{{ t('home.hero.eyebrow') }}</p>
                    <h1 class="mt-5 font-display text-[2.5rem] font-extrabold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-[3.6rem]">
                        {{ t('home.hero.title') }}
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-brand-beige/90">{{ t('home.hero.lead') }}</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <Link :href="localePath('quote')" class="btn btn--primary">{{ t('actions.get_free_quote') }}</Link>
                        <a href="#solutions" class="btn btn--outline-light">{{ t('actions.explore_solutions') }}</a>
                    </div>
                    <ul class="mt-10 flex flex-wrap gap-x-7 gap-y-3 text-sm text-brand-beige/90">
                        <li v-for="b in heroBadges" :key="b" class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-brand-yellow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5" /></svg>
                            {{ b }}
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- STATS -->
        <section class="bg-brand-navy">
            <div class="container-x py-14">
                <div class="grid grid-cols-2 gap-x-6 gap-y-10 text-center lg:grid-cols-4">
                    <div v-for="s in stats" :key="s.l">
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
                    <p class="eyebrow">{{ t('home.solutions.eyebrow') }}</p>
                    <h2 class="heading mt-4">{{ t('home.solutions.heading') }}</h2>
                    <p class="lead mt-4">{{ t('home.solutions.lead') }}</p>
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
                    <p class="eyebrow">{{ t('home.sectors.eyebrow') }}</p>
                    <h2 class="heading mt-4">{{ t('home.sectors.heading') }}</h2>
                    <p class="lead mt-4">{{ t('home.sectors.lead') }}</p>
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
                    <p class="eyebrow">{{ t('home.why.eyebrow') }}</p>
                    <h2 class="heading mt-4">{{ t('home.why.heading') }}</h2>
                    <p class="lead mt-4">{{ t('home.why.lead') }}</p>
                    <Link :href="localePath('about')" class="btn btn--primary mt-7">{{ t('actions.more_about') }}</Link>
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
                    <p class="eyebrow">{{ t('home.process.eyebrow') }}</p>
                    <h2 class="heading mt-4">{{ t('home.process.heading') }}</h2>
                    <p class="lead mt-4">{{ t('home.process.lead') }}</p>
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
