<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import ProductCard from '@/components/marketing/ProductCard.vue';
import { useTranslations } from '@/composables/useTranslations';
import { categoryIcon } from '@/lib/categoryIcons';
import { Head, Link } from '@inertiajs/vue3';

interface Category {
    slug: string;
    name: string;
    icon: string | null;
    count: number;
}

defineProps<{
    categories: Category[];
    featured: Array<{
        slug: string;
        name: string;
        summary: string | null;
        tags: string[];
        image: string | null;
        category_slug: string | null;
        category_name: string | null;
    }>;
}>();

const { t, localePath } = useTranslations();
</script>

<template>
    <Head :title="t('products.meta_title')">
        <meta name="description" :content="t('products.meta_description')" />
    </Head>

    <PublicLayout>
        <!-- Header -->
        <section class="border-b border-brand-border bg-brand-beige">
            <div class="container-x py-16 md:py-20">
                <p class="eyebrow">{{ t('products.header.eyebrow') }}</p>
                <h1 class="heading mt-4 max-w-3xl">{{ t('products.header.title') }}</h1>
                <p class="lead mt-4 max-w-2xl">{{ t('products.header.lead') }}</p>
            </div>
        </section>

        <!-- Categories -->
        <section class="section">
            <div class="container-x">
                <h2 class="heading text-2xl">{{ t('products.browse') }}</h2>
                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="c in categories"
                        :key="c.slug"
                        :href="localePath('products', `/${c.slug}`)"
                        class="group flex items-center gap-4 rounded-card border border-brand-border bg-white p-5 transition hover:-translate-y-1 hover:border-brand-blue hover:shadow-lg"
                    >
                        <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-brand-blue/10 text-brand-blue">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" v-html="categoryIcon(c.icon)" />
                        </span>
                        <span class="min-w-0">
                            <span class="block font-display text-lg font-bold text-brand-navy transition group-hover:text-brand-blue">{{ c.name }}</span>
                            <span class="mt-0.5 block text-sm text-brand-muted">{{ c.count }} {{ t('products.products_count') }}</span>
                        </span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Featured -->
        <section v-if="featured.length" class="section bg-brand-beige pt-0 md:pt-0">
            <div class="container-x pt-[4.5rem] md:pt-24">
                <h2 class="heading text-2xl">{{ t('products.featured') }}</h2>
                <div class="mt-8 grid gap-7 md:grid-cols-2 lg:grid-cols-3">
                    <ProductCard v-for="p in featured" :key="p.slug" :product="p" />
                </div>
            </div>
        </section>

        <CtaSection />
    </PublicLayout>
</template>
