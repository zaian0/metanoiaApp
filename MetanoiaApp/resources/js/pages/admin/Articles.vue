<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Row {
    id: number;
    title: string;
    slug: string;
    category: string | null;
    status: string;
    published_at: string | null;
    updated_at: string;
}
interface Paginated {
    data: Row[];
    links: { url: string | null; label: string; active: boolean }[];
}

defineProps<{
    articles: Paginated;
    filters: { status: string | null };
    statuses: Record<string, string>;
    counts: Record<string, number>;
    total: number;
}>();

const page = usePage();
const success = computed(() => (page.props.flash as { success?: string } | undefined)?.success);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Articles', href: '/dashboard/articles' },
];

const statusClass: Record<string, string> = {
    draft: 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300',
    published: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
};

const destroy = (row: Row) => {
    if (confirm(`Delete “${row.title}”? This cannot be undone.`)) {
        router.delete(route('admin.articles.destroy', row.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Articles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-5 p-4">
            <div class="flex items-center justify-between gap-4">
                <h1 class="text-xl font-semibold">Articles</h1>
                <Link :href="route('admin.articles.create')" class="rounded-lg bg-brand-blue px-4 py-2 text-sm font-medium text-white transition hover:brightness-95">
                    + New article
                </Link>
            </div>

            <div v-if="success" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ success }}
            </div>

            <!-- filter tabs -->
            <div class="flex flex-wrap gap-2">
                <Link :href="route('admin.articles.index')" class="rounded-full border px-3.5 py-1.5 text-sm transition" :class="!filters.status ? 'border-brand-blue bg-brand-blue text-white' : 'border-sidebar-border/70 hover:bg-muted dark:border-sidebar-border'">
                    All <span class="opacity-70">{{ total }}</span>
                </Link>
                <Link v-for="(label, key) in statuses" :key="key" :href="route('admin.articles.index', { status: key })" class="rounded-full border px-3.5 py-1.5 text-sm capitalize transition" :class="filters.status === key ? 'border-brand-blue bg-brand-blue text-white' : 'border-sidebar-border/70 hover:bg-muted dark:border-sidebar-border'">
                    {{ label }} <span class="opacity-70">{{ counts[key] }}</span>
                </Link>
            </div>

            <!-- table -->
            <div class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <table class="w-full text-sm">
                    <thead class="border-b border-sidebar-border/70 bg-muted/50 text-left text-xs uppercase text-muted-foreground dark:border-sidebar-border">
                        <tr>
                            <th class="px-4 py-3 font-medium">Title</th>
                            <th class="hidden px-4 py-3 font-medium sm:table-cell">Category</th>
                            <th class="hidden px-4 py-3 font-medium md:table-cell">Published</th>
                            <th class="hidden px-4 py-3 font-medium lg:table-cell">Updated</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sidebar-border/70 dark:divide-sidebar-border">
                        <tr v-for="a in articles.data" :key="a.id" class="transition hover:bg-muted/50">
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ a.title }}</p>
                                <p class="text-xs text-muted-foreground">/{{ a.slug }}</p>
                            </td>
                            <td class="hidden px-4 py-3 sm:table-cell">{{ a.category || '—' }}</td>
                            <td class="hidden whitespace-nowrap px-4 py-3 text-muted-foreground md:table-cell">{{ a.published_at || '—' }}</td>
                            <td class="hidden whitespace-nowrap px-4 py-3 text-muted-foreground lg:table-cell">{{ a.updated_at }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium capitalize" :class="statusClass[a.status]">{{ statuses[a.status] }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-3 text-sm">
                                    <a v-if="a.status === 'published'" :href="`/articles/${a.slug}`" target="_blank" rel="noopener" class="text-muted-foreground hover:underline">View</a>
                                    <Link :href="route('admin.articles.edit', a.id)" class="text-brand-blue hover:underline dark:text-blue-400">Edit</Link>
                                    <button type="button" class="text-red-600 hover:underline dark:text-red-400" @click="destroy(a)">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!articles.data.length">
                            <td colspan="6" class="px-4 py-12 text-center text-muted-foreground">
                                No articles yet. <Link :href="route('admin.articles.create')" class="text-brand-blue hover:underline">Write your first one →</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- pagination -->
            <div v-if="articles.links.length > 3" class="flex flex-wrap gap-1">
                <component
                    :is="link.url ? Link : 'span'"
                    v-for="(link, i) in articles.links"
                    :key="i"
                    :href="link.url || undefined"
                    class="min-w-9 rounded-md border px-3 py-1.5 text-center text-sm transition"
                    :class="[link.active ? 'border-brand-blue bg-brand-blue text-white' : 'border-sidebar-border/70 hover:bg-muted dark:border-sidebar-border', !link.url && 'pointer-events-none opacity-40']"
                >
                    <span v-html="link.label" />
                </component>
            </div>
        </div>
    </AppLayout>
</template>
