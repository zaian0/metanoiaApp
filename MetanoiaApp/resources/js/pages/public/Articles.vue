<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import { useTranslations } from '@/composables/useTranslations';
import { Head, Link } from '@inertiajs/vue3';

interface Card {
    title: string;
    slug: string;
    category: string | null;
    excerpt: string | null;
    cover_image: string | null;
    author: string | null;
    read_minutes: number;
    published_at: string | null;
}
interface Paginated {
    data: Card[];
    links: { url: string | null; label: string; active: boolean }[];
}

defineProps<{
    articles: Paginated;
    categories: string[];
    filters: { category: string | null };
}>();

const { t, localePath } = useTranslations();
</script>

<template>
    <Head :title="t('articles.meta_title')">
        <meta name="description" :content="t('articles.meta_description')" />
    </Head>

    <PublicLayout>
        <!-- Header -->
        <section class="border-b border-brand-border bg-brand-beige">
            <div class="container-x py-16 md:py-20">
                <p class="eyebrow">{{ t('articles.header.eyebrow') }}</p>
                <h1 class="heading mt-4 max-w-3xl">{{ t('articles.header.title') }}</h1>
                <p class="lead mt-4 max-w-2xl">{{ t('articles.header.lead') }}</p>
            </div>
        </section>

        <section class="section">
            <div class="container-x">
                <!-- Category filter -->
                <div v-if="categories.length" class="mb-10 flex flex-wrap gap-2">
                    <Link
                        :href="localePath('articles')"
                        class="rounded-full border px-4 py-2 text-sm font-medium transition"
                        :class="!filters.category ? 'border-brand-blue bg-brand-blue text-white' : 'border-brand-border text-brand-navy hover:border-brand-blue'"
                    >
                        {{ t('articles.all') }}
                    </Link>
                    <Link
                        v-for="c in categories"
                        :key="c"
                        :href="`${localePath('articles')}?category=${encodeURIComponent(c)}`"
                        class="rounded-full border px-4 py-2 text-sm font-medium transition"
                        :class="filters.category === c ? 'border-brand-blue bg-brand-blue text-white' : 'border-brand-border text-brand-navy hover:border-brand-blue'"
                    >
                        {{ c }}
                    </Link>
                </div>

                <!-- Grid -->
                <div v-if="articles.data.length" class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="a in articles.data"
                        :key="a.slug"
                        class="group flex flex-col overflow-hidden rounded-card border border-brand-border bg-white transition hover:-translate-y-1 hover:shadow-lg"
                    >
                        <Link :href="localePath('articles', '/' + a.slug)" class="block aspect-[16/9] overflow-hidden">
                            <img
                                v-if="a.cover_image"
                                :src="a.cover_image"
                                :alt="a.title"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            />
                            <span v-else class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-blue to-brand-navy-soft">
                                <img src="/brand/sun.png" alt="" class="h-14 w-14 opacity-90" />
                            </span>
                        </Link>
                        <div class="flex flex-1 flex-col p-6">
                            <div class="mb-3 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-brand-blue">
                                <span v-if="a.category">{{ a.category }}</span>
                                <span v-if="a.category" class="text-brand-border">•</span>
                                <span class="text-brand-muted">{{ a.read_minutes }} {{ t('articles.min_read') }}</span>
                            </div>
                            <h2 class="font-display text-lg font-bold leading-snug text-brand-navy">
                                <Link :href="localePath('articles', '/' + a.slug)" class="transition hover:text-brand-blue">{{ a.title }}</Link>
                            </h2>
                            <p v-if="a.excerpt" class="mt-2 line-clamp-3 text-sm leading-relaxed text-brand-muted">{{ a.excerpt }}</p>
                            <div class="mt-5 flex items-center justify-between pt-4 text-xs text-brand-muted">
                                <span>{{ a.author }}</span>
                                <span>{{ a.published_at }}</span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Empty -->
                <div v-else class="rounded-card border border-dashed border-brand-border py-20 text-center">
                    <p class="font-display text-lg font-semibold text-brand-navy">{{ t('articles.empty.title') }}</p>
                    <p class="mt-2 text-brand-muted">{{ t('articles.empty.text') }}</p>
                </div>

                <!-- Pagination -->
                <div v-if="articles.links.length > 3" class="mt-12 flex flex-wrap justify-center gap-1">
                    <component
                        :is="link.url ? Link : 'span'"
                        v-for="(link, i) in articles.links"
                        :key="i"
                        :href="link.url || undefined"
                        class="min-w-10 rounded-md border px-3 py-2 text-center text-sm transition"
                        :class="[
                            link.active ? 'border-brand-blue bg-brand-blue text-white' : 'border-brand-border text-brand-navy hover:border-brand-blue',
                            !link.url && 'pointer-events-none opacity-40',
                        ]"
                    >
                        <span v-html="link.label" />
                    </component>
                </div>
            </div>
        </section>

        <CtaSection />
    </PublicLayout>
</template>
