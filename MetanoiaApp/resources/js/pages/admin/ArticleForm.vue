<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import InputError from '@/components/InputError.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

interface ArticleData {
    id: number;
    locale: string;
    translate_of: number | null;
    title: string;
    slug: string | null;
    category: string | null;
    excerpt: string | null;
    body: string;
    cover_image: string | null;
    author: string | null;
    meta_title: string | null;
    meta_description: string | null;
    status: string;
    published_at: string | null;
}

interface Linkable {
    id: number;
    title: string;
    locale: string;
    group_id: string | null;
}

const props = defineProps<{
    article: ArticleData | null;
    statuses: Record<string, string>;
    categories: string[];
    locales: Record<string, string>;
    linkable: Linkable[];
}>();

const isEdit = computed(() => props.article !== null);

const form = useForm({
    locale: props.article?.locale ?? 'en',
    translate_of: props.article?.translate_of ?? null,
    title: props.article?.title ?? '',
    slug: props.article?.slug ?? '',
    category: props.article?.category ?? '',
    excerpt: props.article?.excerpt ?? '',
    body: props.article?.body ?? '',
    cover_image: props.article?.cover_image ?? '',
    author: props.article?.author ?? '',
    meta_title: props.article?.meta_title ?? '',
    meta_description: props.article?.meta_description ?? '',
    status: props.article?.status ?? 'draft',
    published_at: props.article?.published_at ?? '',
});

// You can only link to a translation written in a different locale.
const linkOptions = computed(() => props.linkable.filter((a) => a.locale !== form.locale));


const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Articles', href: '/dashboard/articles' },
    { title: isEdit.value ? 'Edit' : 'New', href: '#' },
];

const submit = () => {
    if (isEdit.value && props.article) {
        form.put(route('admin.articles.update', props.article.id));
    } else {
        form.post(route('admin.articles.store'));
    }
};

const inputClass =
    'w-full rounded-lg border border-sidebar-border/70 bg-background px-3 py-2 text-sm outline-none transition focus:border-brand-blue focus:ring-1 focus:ring-brand-blue dark:border-sidebar-border';
</script>

<template>
    <Head :title="isEdit ? 'Edit article' : 'New article'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <form class="mx-auto flex w-full max-w-3xl flex-1 flex-col gap-6 p-4" @submit.prevent="submit">
            <div class="flex items-center justify-between gap-4">
                <h1 class="text-xl font-semibold">{{ isEdit ? 'Edit article' : 'New article' }}</h1>
                <Link :href="route('admin.articles.index')" class="text-sm text-muted-foreground hover:underline">← Back</Link>
            </div>

            <!-- Language & translation link -->
            <div class="grid gap-5 rounded-xl border border-sidebar-border/70 p-5 sm:grid-cols-2 dark:border-sidebar-border">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Language</label>
                    <select v-model="form.locale" :class="inputClass">
                        <option v-for="(label, key) in locales" :key="key" :value="key">{{ label }}</option>
                    </select>
                    <InputError :message="form.errors.locale" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Translation of <span class="font-normal text-muted-foreground">(optional)</span></label>
                    <select v-model="form.translate_of" :class="inputClass">
                        <option :value="null">— Standalone —</option>
                        <option v-for="a in linkOptions" :key="a.id" :value="a.id">{{ locales[a.locale] }} · {{ a.title }}</option>
                    </select>
                    <p class="mt-1 text-xs text-muted-foreground">Link this to the same article in the other language so readers can switch between them.</p>
                    <InputError :message="form.errors.translate_of" class="mt-1" />
                </div>
            </div>

            <!-- Title -->
            <div>
                <label class="mb-1.5 block text-sm font-medium">Title</label>
                <input v-model="form.title" type="text" :class="inputClass" placeholder="How rooftop solar cuts factory energy costs" />
                <InputError :message="form.errors.title" class="mt-1" />
            </div>

            <!-- Slug + Category -->
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Slug <span class="font-normal text-muted-foreground">(optional)</span></label>
                    <input v-model="form.slug" type="text" :class="inputClass" placeholder="auto-generated from title" />
                    <InputError :message="form.errors.slug" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Category</label>
                    <input v-model="form.category" type="text" list="article-categories" :class="inputClass" placeholder="e.g. Guides" />
                    <datalist id="article-categories">
                        <option v-for="c in categories" :key="c" :value="c" />
                    </datalist>
                    <InputError :message="form.errors.category" class="mt-1" />
                </div>
            </div>

            <!-- Excerpt -->
            <div>
                <label class="mb-1.5 block text-sm font-medium">Excerpt <span class="font-normal text-muted-foreground">(card + SEO summary)</span></label>
                <textarea v-model="form.excerpt" rows="2" maxlength="500" :class="inputClass" placeholder="One or two sentences summarizing the article." />
                <p class="mt-1 text-right text-xs text-muted-foreground">{{ form.excerpt.length }}/500</p>
                <InputError :message="form.errors.excerpt" class="mt-1" />
            </div>

            <!-- Body -->
            <div>
                <label class="mb-1.5 block text-sm font-medium">Body <span class="font-normal text-muted-foreground">(Markdown)</span></label>
                <textarea v-model="form.body" rows="18" :class="[inputClass, 'font-mono text-[13px] leading-relaxed']" placeholder="## Heading&#10;&#10;Write your article in Markdown. Use **bold**, _italics_, lists, [links](https://…), and > quotes." />
                <p class="mt-1 text-xs text-muted-foreground">Supports Markdown: headings, <strong>**bold**</strong>, lists, links, and blockquotes. Raw HTML is stripped for safety.</p>
                <InputError :message="form.errors.body" class="mt-1" />
            </div>

            <!-- Cover + Author -->
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Cover image URL <span class="font-normal text-muted-foreground">(optional)</span></label>
                    <input v-model="form.cover_image" type="text" :class="inputClass" placeholder="/images/articles/cover.jpg" />
                    <InputError :message="form.errors.cover_image" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Author</label>
                    <input v-model="form.author" type="text" :class="inputClass" placeholder="Metanoia Energy" />
                    <InputError :message="form.errors.author" class="mt-1" />
                </div>
            </div>

            <!-- Publishing -->
            <div class="grid gap-5 rounded-xl border border-sidebar-border/70 p-5 sm:grid-cols-2 dark:border-sidebar-border">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Status</label>
                    <select v-model="form.status" :class="inputClass">
                        <option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option>
                    </select>
                    <InputError :message="form.errors.status" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Publish date <span class="font-normal text-muted-foreground">(optional)</span></label>
                    <input v-model="form.published_at" type="datetime-local" :class="inputClass" />
                    <p class="mt-1 text-xs text-muted-foreground">Left empty, it's set to now when published.</p>
                    <InputError :message="form.errors.published_at" class="mt-1" />
                </div>
            </div>

            <!-- SEO -->
            <details class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                <summary class="cursor-pointer text-sm font-medium">SEO overrides (optional)</summary>
                <div class="mt-4 flex flex-col gap-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Meta title</label>
                        <input v-model="form.meta_title" type="text" :class="inputClass" placeholder="Falls back to the article title" />
                        <InputError :message="form.errors.meta_title" class="mt-1" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Meta description</label>
                        <textarea v-model="form.meta_description" rows="2" maxlength="500" :class="inputClass" placeholder="Falls back to the excerpt" />
                        <InputError :message="form.errors.meta_description" class="mt-1" />
                    </div>
                </div>
            </details>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-blue px-5 py-2.5 text-sm font-medium text-white transition hover:brightness-95 disabled:opacity-50">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Save changes' : 'Create article' }}
                </button>
                <Link :href="route('admin.articles.index')" class="rounded-lg border border-sidebar-border/70 px-5 py-2.5 text-sm transition hover:bg-muted dark:border-sidebar-border">Cancel</Link>
            </div>
        </form>
    </AppLayout>
</template>
