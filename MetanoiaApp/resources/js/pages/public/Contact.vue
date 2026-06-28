<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import { useTranslations } from '@/composables/useTranslations';
import { Head } from '@inertiajs/vue3';
import { site } from '@/lib/site';

const { t } = useTranslations();

const mapEmbed = `https://www.google.com/maps?q=${site.mapsQuery}&output=embed`;
const mapLink = `https://www.google.com/maps?q=${site.mapsQuery}`;
</script>

<template>
    <Head :title="t('contact.meta_title')">
        <meta name="description" :content="t('contact.meta_description')" />
    </Head>

    <PublicLayout>
        <!-- HERO -->
        <section class="relative overflow-hidden bg-brand-beige/50">
            <div class="container-x max-w-3xl py-16 lg:py-20">
                <p class="eyebrow">{{ t('contact.hero.eyebrow') }}</p>
                <h1 class="mt-5 font-display text-4xl font-extrabold leading-[1.1] tracking-tight text-brand-blue lg:text-[3rem]">{{ t('contact.hero.title') }}</h1>
                <p class="lead mt-6">{{ t('contact.hero.lead') }}</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a :href="site.whatsappMsg" target="_blank" rel="noopener" class="btn btn--wa">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Z" /></svg>
                        {{ t('contact.hero.whatsapp') }}
                    </a>
                    <a :href="`tel:+${site.phoneIntl}`" class="btn btn--ghost">{{ t('actions.call') }} {{ site.phone }}</a>
                </div>
            </div>
        </section>

        <!-- DETAILS + MAP -->
        <section class="section">
            <div class="container-x grid items-start gap-10 lg:grid-cols-2 lg:gap-14">
                <div>
                    <p class="eyebrow">{{ t('contact.reach.eyebrow') }}</p>
                    <h2 class="heading mt-4">{{ t('contact.reach.heading') }}</h2>

                    <div class="mt-8 grid gap-5 sm:grid-cols-2">
                        <a :href="`tel:+${site.phoneIntl}`" class="card-b block !p-6">
                            <h3 class="font-display text-lg font-bold text-brand-blue">{{ t('contact.cards.call') }}</h3>
                            <p class="mt-1 text-brand-muted">{{ site.phone }}</p>
                        </a>
                        <a :href="site.whatsappMsg" target="_blank" rel="noopener" class="card-b block !p-6">
                            <h3 class="font-display text-lg font-bold text-brand-blue">{{ t('contact.cards.whatsapp') }}</h3>
                            <p class="mt-1 text-brand-muted">{{ site.phone }}</p>
                        </a>
                        <a :href="`mailto:${site.email}`" class="card-b block !p-6">
                            <h3 class="font-display text-lg font-bold text-brand-blue">{{ t('contact.cards.email') }}</h3>
                            <p class="mt-1 break-all text-brand-muted">{{ site.email }}</p>
                        </a>
                        <a :href="mapLink" target="_blank" rel="noopener" class="card-b block !p-6">
                            <h3 class="font-display text-lg font-bold text-brand-blue">{{ t('contact.cards.visit') }}</h3>
                            <p class="mt-1 text-brand-muted">{{ site.address }}</p>
                        </a>
                    </div>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div class="card-b card-b--blue !p-6">
                            <h3 class="font-display text-lg font-bold text-brand-blue">{{ t('contact.hours.title') }}</h3>
                            <p class="mt-1 text-brand-muted">{{ site.hours }}</p>
                            <p class="mt-1 text-sm text-brand-muted">{{ t('contact.hours.closed') }}</p>
                        </div>
                        <div class="card-b card-b--gold !p-6">
                            <h3 class="font-display text-lg font-bold text-brand-blue">{{ site.founderName }}</h3>
                            <p class="mt-1 text-brand-muted">{{ t('contact.founder_role') }}</p>
                            <a :href="`mailto:${site.founderEmail}`" class="mt-2 inline-block break-all text-sm font-medium text-brand-blue hover:underline">{{ site.founderEmail }}</a>
                        </div>
                    </div>
                </div>

                <div class="lg:sticky lg:top-28">
                    <div class="overflow-hidden rounded-[24px] border border-brand-border bg-white">
                        <iframe :title="t('contact.map_title')" :src="mapEmbed" width="100%" height="460" style="border: 0; display: block" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-brand-muted">{{ site.address }}</p>
                        <a :href="mapLink" target="_blank" rel="noopener" class="btn btn--ghost !px-5 !py-2.5 !text-sm shrink-0">{{ t('actions.get_directions') }}</a>
                    </div>
                </div>
            </div>
        </section>

        <CtaSection />
    </PublicLayout>
</template>
