<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import ProductCard from '@/components/marketing/ProductCard.vue';
import { useTranslations } from '@/composables/useTranslations';
import { categoryIcon } from '@/lib/categoryIcons';
import { Head, Link } from '@inertiajs/vue3';

interface NavCat {
    slug: string;
    name: string;
    icon: string | null;
}
interface Card {
    slug: string;
    name: string;
    summary: string | null;
    tags: string[];
    image: string | null;
    category_slug: string | null;
    category_name: string | null;
}

const props = defineProps<{
    category: { slug: string; name: string; icon: string | null };
    products: Card[];
    tags: string[];
    filters: { tag: string | null };
    categories: NavCat[];
}>();

const { t, localePath } = useTranslations();

const base = () => localePath('products', `/${props.category.slug}`);
</script>

<template>
    <Head :title="`${category.name} — ${t('nav.products')} | Metanoia Energy`" />

    <PublicLayout>
        <!-- Header -->
        <section class="border-b border-brand-border bg-brand-beige">
            <div class="container-x py-14 md:py-16">
                <Link :href="localePath('products')" class="text-sm font-medium text-brand-blue hover:underline">{{ t('products.all_products') }}</Link>
                <div class="mt-5 flex items-center gap-4">
                    <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-brand-blue/10 text-brand-blue">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" v-html="categoryIcon(category.icon)" />
                    </span>
                    <h1 class="heading">{{ category.name }}</h1>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container-x">
                <!-- Category nav -->
                <div class="mb-6 flex flex-wrap gap-2">
                    <Link
                        :href="localePath('products')"
                        class="rounded-full border px-4 py-2 text-sm font-medium transition border-brand-border text-brand-navy hover:border-brand-blue"
                    >
                        {{ t('products.all_products') }}
                    </Link>
                    <Link
                        v-for="c in categories"
                        :key="c.slug"
                        :href="localePath('products', `/${c.slug}`)"
                        class="rounded-full border px-4 py-2 text-sm font-medium transition"
                        :class="c.slug === category.slug ? 'border-brand-blue bg-brand-blue text-white' : 'border-brand-border text-brand-navy hover:border-brand-blue'"
                    >
                        {{ c.name }}
                    </Link>
                </div>

                <!-- Tag filter -->
                <div v-if="tags.length" class="mb-10 flex flex-wrap items-center gap-2 border-t border-brand-border pt-6">
                    <Link
                        :href="base()"
                        class="rounded-full px-3 py-1.5 text-sm transition"
                        :class="!filters.tag ? 'bg-brand-navy text-white' : 'text-brand-muted hover:text-brand-blue'"
                    >
                        {{ t('products.all') }}
                    </Link>
                    <Link
                        v-for="tag in tags"
                        :key="tag"
                        :href="`${base()}?tag=${encodeURIComponent(tag)}`"
                        class="rounded-full px-3 py-1.5 text-sm transition"
                        :class="filters.tag === tag ? 'bg-brand-navy text-white' : 'text-brand-muted hover:text-brand-blue'"
                    >
                        {{ tag }}
                    </Link>
                </div>

                <!-- Products -->
                <div v-if="products.length" class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
                    <ProductCard v-for="p in products" :key="p.slug" :product="p" />
                </div>
                <div v-else class="rounded-card border border-dashed border-brand-border py-20 text-center text-brand-muted">
                    {{ t('products.empty') }}
                </div>
            </div>
        </section>

        <CtaSection />
    </PublicLayout>
</template>
