<script setup lang="ts">
import { useTranslations } from '@/composables/useTranslations';
import { Link } from '@inertiajs/vue3';
import { site } from '@/lib/site';

const { t, localePath } = useTranslations();
</script>

<template>
    <section class="section">
        <div class="container-x">
            <div class="relative overflow-hidden rounded-[28px] px-7 py-16 text-center md:px-16 md:py-20">
                <img src="/images/hero-art.svg" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full object-cover" />
                <div class="absolute inset-0 bg-brand-navy/80"></div>
                <div class="relative mx-auto max-w-2xl">
                    <p class="eyebrow eyebrow--gold justify-center">{{ t('cta.eyebrow') }}</p>
                    <h2 class="heading heading--light mt-4">{{ t('cta.heading') }}</h2>
                    <p class="mt-4 text-lg leading-relaxed text-brand-beige/85">{{ t('cta.lead') }}</p>
                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                        <Link :href="localePath('quote')" class="btn btn--gold">{{ t('cta.request') }}</Link>
                        <a :href="site.whatsappMsg" target="_blank" rel="noopener" class="btn btn--wa">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm5.8 14.16c-.25.69-1.44 1.32-1.98 1.36-.53.05-1.02.24-3.45-.72-2.9-1.14-4.76-4.1-4.9-4.29-.14-.19-1.18-1.57-1.18-3s.75-2.13 1.02-2.42c.27-.29.58-.36.78-.36.19 0 .39 0 .56.01.18.01.42-.07.66.5.25.59.84 2.04.91 2.19.07.14.12.31.02.5-.09.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.27.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.21 1.37.27.14.43.12.59-.07.16-.19.68-.79.86-1.06.18-.27.36-.22.61-.13.25.09 1.6.75 1.87.89.27.14.45.21.52.32.07.12.07.66-.18 1.35Z" /></svg>
                            {{ t('cta.whatsapp') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
