<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import CtaSection from '@/components/marketing/CtaSection.vue';
import { Head, Link } from '@inertiajs/vue3';

interface Related {
    title: string;
    slug: string;
    category: string | null;
    excerpt: string | null;
    cover_image: string | null;
    read_minutes: number;
    published_at: string | null;
}

const props = defineProps<{
    article: {
        title: string;
        slug: string;
        category: string | null;
        excerpt: string | null;
        body_html: string;
        cover_image: string | null;
        author: string | null;
        read_minutes: number;
        published_at: string | null;
        published_at_iso: string | null;
        meta_title: string;
        meta_description: string | null;
    };
    related: Related[];
}>();

const canonical = typeof window !== 'undefined' ? window.location.href : '';

const jsonLd = JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'Article',
    headline: props.article.title,
    description: props.article.meta_description ?? undefined,
    image: props.article.cover_image ?? undefined,
    datePublished: props.article.published_at_iso ?? undefined,
    author: { '@type': 'Organization', name: props.article.author ?? 'Metanoia Energy' },
    publisher: { '@type': 'Organization', name: 'Metanoia Energy' },
});
</script>

<template>
    <Head :title="`${article.meta_title} — Metanoia Energy`">
        <meta v-if="article.meta_description" name="description" :content="article.meta_description" />
        <meta property="og:type" content="article" />
        <meta property="og:title" :content="article.meta_title" />
        <meta v-if="article.meta_description" property="og:description" :content="article.meta_description" />
        <meta v-if="article.cover_image" property="og:image" :content="article.cover_image" />
        <link v-if="canonical" rel="canonical" :href="canonical" />
        <component :is="'script'" type="application/ld+json">{{ jsonLd }}</component>
    </Head>

    <PublicLayout>
        <article>
            <!-- Header -->
            <header class="border-b border-brand-border bg-brand-beige">
                <div class="container-x py-14 md:py-16">
                    <div class="mx-auto max-w-3xl">
                        <Link href="/articles" class="text-sm font-medium text-brand-blue hover:underline">← All articles</Link>
                        <div class="mt-5 flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-wide text-brand-blue">
                            <span v-if="article.category">{{ article.category }}</span>
                            <span v-if="article.category" class="text-brand-border">•</span>
                            <span class="text-brand-muted">{{ article.read_minutes }} min read</span>
                        </div>
                        <h1 class="mt-3 font-display text-3xl font-extrabold leading-tight tracking-tight text-brand-navy md:text-[2.6rem]">
                            {{ article.title }}
                        </h1>
                        <p v-if="article.excerpt" class="mt-4 text-lg leading-relaxed text-brand-muted">{{ article.excerpt }}</p>
                        <div class="mt-6 flex items-center gap-3 text-sm text-brand-muted">
                            <span class="font-medium text-brand-navy">{{ article.author }}</span>
                            <span v-if="article.published_at">·</span>
                            <time v-if="article.published_at" :datetime="article.published_at_iso ?? undefined">{{ article.published_at }}</time>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Cover -->
            <div v-if="article.cover_image" class="container-x -mt-px">
                <div class="mx-auto max-w-4xl">
                    <img :src="article.cover_image" :alt="article.title" class="mt-10 aspect-[16/8] w-full rounded-card object-cover" />
                </div>
            </div>

            <!-- Body -->
            <div class="container-x py-14 md:py-16">
                <div class="prose-article mx-auto max-w-3xl" v-html="article.body_html" />
            </div>
        </article>

        <!-- Related -->
        <section v-if="related.length" class="border-t border-brand-border bg-brand-snow">
            <div class="container-x py-16">
                <h2 class="heading text-2xl">More from Metanoia</h2>
                <div class="mt-8 grid gap-7 md:grid-cols-3">
                    <article
                        v-for="a in related"
                        :key="a.slug"
                        class="group flex flex-col overflow-hidden rounded-card border border-brand-border bg-white transition hover:-translate-y-1 hover:shadow-lg"
                    >
                        <Link :href="route('articles.show', a.slug)" class="block aspect-[16/9] overflow-hidden">
                            <img v-if="a.cover_image" :src="a.cover_image" :alt="a.title" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                            <span v-else class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-blue to-brand-navy-soft">
                                <img src="/brand/sun.png" alt="" class="h-12 w-12 opacity-90" />
                            </span>
                        </Link>
                        <div class="flex flex-1 flex-col p-6">
                            <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-brand-blue">{{ a.category || 'Article' }}</div>
                            <h3 class="font-display text-base font-bold leading-snug text-brand-navy">
                                <Link :href="route('articles.show', a.slug)" class="transition hover:text-brand-blue">{{ a.title }}</Link>
                            </h3>
                            <p class="mt-3 text-xs text-brand-muted">{{ a.published_at }} · {{ a.read_minutes }} min read</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <CtaSection />
    </PublicLayout>
</template>
