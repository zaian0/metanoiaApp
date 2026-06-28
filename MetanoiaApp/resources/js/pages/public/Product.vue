<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import ProductCard from '@/components/marketing/ProductCard.vue';
import { useTranslations } from '@/composables/useTranslations';
import { site } from '@/lib/site';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface Img {
    path: string;
    alt: string | null;
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
    product: {
        slug: string;
        name: string;
        summary: string | null;
        description_html: string;
        tags: string[];
        specs: Array<{ label: string; value: string }>;
        images: Img[];
        category: { slug: string; name: string };
    };
    related: Card[];
}>();

const { t, localePath } = useTranslations();

const active = ref(0);
const mainImage = computed(() => props.product.images[active.value] ?? props.product.images[0] ?? null);

const quoteHref = computed(() => `${localePath('quote')}?product=${encodeURIComponent(props.product.name)}`);
const whatsappHref = computed(
    () =>
        `https://wa.me/${site.phoneIntl}?text=` +
        encodeURIComponent(`${t('quote.wa.greeting')}\n${t('quote.wa.name')}: ${props.product.name}`),
);
</script>

<template>
    <Head :title="`${product.name} — Metanoia Energy`">
        <meta v-if="product.summary" name="description" :content="product.summary" />
        <meta property="og:type" content="product" />
        <meta property="og:title" :content="product.name" />
        <meta v-if="product.images.length" property="og:image" :content="product.images[0].path" />
    </Head>

    <PublicLayout>
        <section class="section">
            <div class="container-x">
                <!-- Breadcrumb -->
                <nav class="mb-8 flex flex-wrap items-center gap-2 text-sm text-brand-muted">
                    <Link :href="localePath('products')" class="hover:text-brand-blue">{{ t('nav.products') }}</Link>
                    <span>/</span>
                    <Link :href="localePath('products', `/${product.category.slug}`)" class="hover:text-brand-blue">{{ product.category.name }}</Link>
                </nav>

                <div class="grid gap-10 lg:grid-cols-2 lg:gap-14">
                    <!-- Gallery -->
                    <div>
                        <div class="aspect-square overflow-hidden rounded-card border border-brand-border bg-white">
                            <img v-if="mainImage" :src="mainImage.path" :alt="mainImage.alt || product.name" class="h-full w-full object-cover" />
                            <span v-else class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-blue to-brand-navy-soft">
                                <img src="/brand/sun.png" alt="" class="h-20 w-20 opacity-90" />
                            </span>
                        </div>
                        <div v-if="product.images.length > 1" class="mt-3 grid grid-cols-5 gap-3">
                            <button
                                v-for="(img, i) in product.images"
                                :key="i"
                                type="button"
                                class="aspect-square overflow-hidden rounded-lg border-2 transition"
                                :class="i === active ? 'border-brand-blue' : 'border-brand-border hover:border-brand-blue/50'"
                                @click="active = i"
                            >
                                <img :src="img.path" :alt="img.alt || product.name" class="h-full w-full object-cover" />
                            </button>
                        </div>
                    </div>

                    <!-- Info -->
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-brand-blue">{{ product.category.name }}</p>
                        <h1 class="mt-2 font-display text-3xl font-extrabold leading-tight tracking-tight text-brand-navy md:text-4xl">{{ product.name }}</h1>
                        <div v-if="product.tags.length" class="mt-4 flex flex-wrap gap-2">
                            <span v-for="tag in product.tags" :key="tag" class="rounded-full bg-brand-blue/5 px-3 py-1 text-sm font-medium text-brand-blue">{{ tag }}</span>
                        </div>
                        <p v-if="product.summary" class="lead mt-5">{{ product.summary }}</p>

                        <!-- CTA -->
                        <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                            <Link :href="quoteHref" class="btn btn--primary">{{ t('products.request_quote') }}</Link>
                            <a :href="whatsappHref" target="_blank" rel="noopener" class="btn btn--wa">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Z" /></svg>
                                {{ t('actions.whatsapp_us') }}
                            </a>
                        </div>

                        <!-- Specs -->
                        <div v-if="product.specs.length" class="mt-8 rounded-card border border-brand-border">
                            <p class="border-b border-brand-border px-5 py-3 font-display font-bold text-brand-blue">{{ t('products.specs') }}</p>
                            <dl class="divide-y divide-brand-border">
                                <div v-for="s in product.specs" :key="s.label" class="flex justify-between gap-4 px-5 py-3 text-sm">
                                    <dt class="text-brand-muted">{{ s.label }}</dt>
                                    <dd class="text-end font-medium text-brand-navy">{{ s.value }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div v-if="product.description_html" class="mt-14 border-t border-brand-border pt-10">
                    <div class="prose-article max-w-3xl" v-html="product.description_html" />
                </div>
            </div>
        </section>

        <!-- Related -->
        <section v-if="related.length" class="border-t border-brand-border bg-brand-snow">
            <div class="container-x py-16">
                <h2 class="heading text-2xl">{{ t('products.related') }}</h2>
                <div class="mt-8 grid gap-7 sm:grid-cols-2 lg:grid-cols-4">
                    <ProductCard v-for="p in related" :key="p.slug" :product="p" />
                </div>
            </div>
        </section>

        <CtaSection />
    </PublicLayout>
</template>
