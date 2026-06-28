<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { categoryIcon } from '@/lib/categoryIcons';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Row {
    id: number;
    name_en: string;
    name_ar: string | null;
    slug: string;
    icon: string | null;
    sort_order: number;
    products_count: number;
}

defineProps<{ categories: Row[]; icons: string[] }>();

const page = usePage();
const flash = computed(() => page.props.flash as { success?: string; error?: string } | undefined);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Categories', href: '/dashboard/product-categories' },
];

const destroy = (row: Row) => {
    if (confirm(`Delete category “${row.name_en}”?`)) {
        router.delete(route('admin.product-categories.destroy', row.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Product categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-5 p-4">
            <div class="flex items-center justify-between gap-4">
                <h1 class="text-xl font-semibold">Product categories</h1>
                <Link :href="route('admin.product-categories.create')" class="rounded-lg bg-brand-blue px-4 py-2 text-sm font-medium text-white transition hover:brightness-95">+ New category</Link>
            </div>

            <div v-if="flash?.success" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">{{ flash.success }}</div>
            <div v-if="flash?.error" class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-300">{{ flash.error }}</div>

            <div class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <table class="w-full text-sm">
                    <thead class="border-b border-sidebar-border/70 bg-muted/50 text-left text-xs uppercase text-muted-foreground dark:border-sidebar-border">
                        <tr>
                            <th class="px-4 py-3 font-medium">Category</th>
                            <th class="hidden px-4 py-3 font-medium sm:table-cell">Arabic</th>
                            <th class="px-4 py-3 font-medium">Products</th>
                            <th class="px-4 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sidebar-border/70 dark:divide-sidebar-border">
                        <tr v-for="c in categories" :key="c.id" class="transition hover:bg-muted/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-brand-blue/10 text-brand-blue">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" v-html="categoryIcon(c.icon)" />
                                    </span>
                                    <div>
                                        <p class="font-medium">{{ c.name_en }}</p>
                                        <p class="text-xs text-muted-foreground">/{{ c.slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden px-4 py-3 sm:table-cell" dir="rtl">{{ c.name_ar || '—' }}</td>
                            <td class="px-4 py-3 text-muted-foreground">{{ c.products_count }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-3 text-sm">
                                    <Link :href="route('admin.product-categories.edit', c.id)" class="text-brand-blue hover:underline dark:text-blue-400">Edit</Link>
                                    <button type="button" class="text-red-600 hover:underline dark:text-red-400" @click="destroy(c)">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!categories.length">
                            <td colspan="4" class="px-4 py-12 text-center text-muted-foreground">
                                No categories yet. <Link :href="route('admin.product-categories.create')" class="text-brand-blue hover:underline">Add one →</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
