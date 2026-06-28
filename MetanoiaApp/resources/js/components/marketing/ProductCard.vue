<script setup lang="ts">
import { useTranslations } from '@/composables/useTranslations';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

interface ProductCardData {
    slug: string;
    name: string;
    summary: string | null;
    tags: string[];
    image: string | null;
    category_slug: string | null;
    category_name: string | null;
}

const props = defineProps<{ product: ProductCardData }>();

const { t, localePath } = useTranslations();

const detailHref = computed(() => localePath('products', `/${props.product.category_slug}/${props.product.slug}`));
const quoteHref = computed(() => `${localePath('quote')}?product=${encodeURIComponent(props.product.name)}`);
</script>

<template>
    <article class="group flex flex-col overflow-hidden rounded-card border border-brand-border bg-white transition hover:-translate-y-1 hover:shadow-lg">
        <Link :href="detailHref" class="block aspect-[16/10] overflow-hidden">
            <img v-if="product.image" :src="product.image" :alt="product.name" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
            <span v-else class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-blue to-brand-navy-soft">
                <img src="/brand/sun.png" alt="" class="h-12 w-12 opacity-90" />
            </span>
        </Link>
        <div class="flex flex-1 flex-col p-5">
            <p v-if="product.category_name" class="mb-1.5 text-xs font-semibold uppercase tracking-wide text-brand-blue">{{ product.category_name }}</p>
            <h3 class="font-display text-base font-bold leading-snug text-brand-navy">
                <Link :href="detailHref" class="transition hover:text-brand-blue">{{ product.name }}</Link>
            </h3>
            <p v-if="product.summary" class="mt-1.5 line-clamp-2 text-sm leading-relaxed text-brand-muted">{{ product.summary }}</p>
            <div v-if="product.tags.length" class="mt-3 flex flex-wrap gap-1.5">
                <span v-for="tag in product.tags.slice(0, 3)" :key="tag" class="rounded-full bg-brand-blue/5 px-2.5 py-0.5 text-xs font-medium text-brand-blue">{{ tag }}</span>
            </div>
            <div class="mt-auto pt-4">
                <Link :href="quoteHref" class="btn btn--primary w-full !py-2.5 !text-sm">{{ t('products.request_quote') }}</Link>
            </div>
        </div>
    </article>
</template>
