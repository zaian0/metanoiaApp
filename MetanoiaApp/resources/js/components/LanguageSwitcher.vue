<script setup lang="ts">
import { useTranslations } from '@/composables/useTranslations';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const { t, locale } = useTranslations();
const page = usePage();

// Server-provided equivalent URLs for each locale (toggles the /ar prefix;
// the article pages override these with the matching translation's slug).
const alternates = computed(
    () => (page.props.alternates as { en: string; ar: string } | undefined) ?? { en: '/', ar: '/ar' },
);

const target = computed(() => (locale.value === 'ar' ? alternates.value.en : alternates.value.ar));
const label = computed(() => (locale.value === 'ar' ? t('language.en') : t('language.ar')));
</script>

<template>
    <Link
        :href="target"
        class="inline-flex items-center gap-1.5 font-display text-[0.95rem] font-medium text-brand-navy transition hover:text-brand-blue"
        :aria-label="t('language.switch')"
    >
        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="9" />
            <path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18" />
        </svg>
        {{ label }}
    </Link>
</template>
