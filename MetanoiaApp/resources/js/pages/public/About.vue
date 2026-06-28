<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import { useTranslations } from '@/composables/useTranslations';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { site } from '@/lib/site';

const { t, tList } = useTranslations();

const paragraphs = computed(() => tList<string>('about.who.paragraphs'));
const facts = computed(() => tList<{ k: string; v: string }>('about.glance.facts'));
const pillars = computed(() => tList<{ title: string; text: string }>('about.pillars.items'));
const traits = computed(() => tList<string>('about.personality.traits'));
</script>

<template>
    <Head :title="t('about.meta_title')">
        <meta name="description" :content="t('about.meta_description')" />
    </Head>

    <PublicLayout>
        <!-- HERO -->
        <section class="relative overflow-hidden bg-brand-beige/50">
            <div class="container-x max-w-3xl py-16 lg:py-20">
                <p class="eyebrow">{{ t('about.hero.eyebrow') }}</p>
                <h1 class="mt-5 font-display text-4xl font-extrabold leading-[1.1] tracking-tight text-brand-blue lg:text-[3rem]">
                    {{ t('about.hero.title') }}
                </h1>
                <p class="lead mt-6">{{ t('about.hero.lead') }}</p>
            </div>
        </section>

        <!-- WHO WE ARE -->
        <section class="section">
            <div class="container-x grid items-start gap-12 lg:grid-cols-[1.3fr_0.7fr] lg:gap-16">
                <div>
                    <p class="eyebrow">{{ t('about.who.eyebrow') }}</p>
                    <h2 class="heading mt-4">{{ t('about.who.heading') }}</h2>
                    <div class="lead mt-6 space-y-5">
                        <p v-for="(p, i) in paragraphs" :key="i">{{ p }}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-6">
                    <img src="/images/about-art.svg" alt="" class="w-full rounded-[20px] ring-1 ring-brand-border" />
                    <aside class="card-b">
                        <h3 class="font-display text-lg font-bold text-brand-blue">{{ t('about.glance.title') }}</h3>
                        <dl class="mt-5 space-y-4">
                            <div v-for="(f, i) in facts" :key="f.k" class="flex justify-between gap-4 pb-4" :class="i < facts.length - 1 ? 'border-b border-brand-border' : ''">
                                <dt class="text-sm text-brand-muted">{{ f.k }}</dt>
                                <dd class="text-end font-display font-semibold">{{ f.v }}</dd>
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
                    <h3 class="font-display text-xl font-bold text-brand-blue">{{ t('about.vision.title') }}</h3>
                    <p class="mt-2 leading-relaxed text-brand-muted">{{ t('about.vision.text') }}</p>
                </article>
                <article class="card-b card-b--navy">
                    <h3 class="font-display text-xl font-bold text-white">{{ t('about.mission.title') }}</h3>
                    <p class="mt-2 leading-relaxed text-brand-beige/80">{{ t('about.mission.text') }}</p>
                </article>
            </div>
        </section>

        <!-- PILLARS -->
        <section class="section pt-0">
            <div class="container-x">
                <div class="max-w-2xl">
                    <p class="eyebrow">{{ t('about.pillars.eyebrow') }}</p>
                    <h2 class="heading mt-4">{{ t('about.pillars.heading') }}</h2>
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
                    <p class="eyebrow">{{ t('about.personality.eyebrow') }}</p>
                    <h2 class="heading mt-4 max-w-2xl">{{ t('about.personality.heading') }}</h2>
                    <p class="lead mt-4 max-w-2xl">{{ t('about.personality.lead') }}</p>
                    <ul class="mt-8 flex flex-wrap gap-3">
                        <li v-for="tr in traits" :key="tr" class="rounded-full border border-brand-border bg-white px-5 py-2 font-display text-sm font-semibold text-brand-blue">{{ tr }}</li>
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
                        <p class="text-sm font-medium text-brand-yellow">{{ t('about.founder.role') }}</p>
                    </div>
                    <div>
                        <p class="eyebrow eyebrow--gold">{{ t('about.founder.eyebrow') }}</p>
                        <blockquote class="mt-5 font-display text-xl leading-relaxed text-white md:text-2xl">
                            “{{ t('about.founder.quote') }}”
                        </blockquote>
                    </div>
                </div>
            </div>
        </section>

        <CtaSection />
    </PublicLayout>
</template>
