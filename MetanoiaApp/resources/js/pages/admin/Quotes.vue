<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';

interface Row {
    id: number;
    name: string;
    phone: string;
    segment: string;
    service: string;
    location: string;
    status: string;
    created_at: string;
}
interface Paginated {
    data: Row[];
    links: { url: string | null; label: string; active: boolean }[];
}

defineProps<{
    quotes: Paginated;
    filters: { status: string | null };
    statuses: Record<string, string>;
    counts: Record<string, number>;
    total: number;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Quote requests', href: '/dashboard/quotes' },
];

const statusClass: Record<string, string> = {
    new: 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
    contacted: 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300',
    quoted: 'bg-violet-100 text-violet-700 dark:bg-violet-500/15 dark:text-violet-300',
    closed: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
};
</script>

<template>
    <Head title="Quote requests" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-5 p-4">
            <h1 class="text-xl font-semibold">Quote requests</h1>

            <!-- filter tabs -->
            <div class="flex flex-wrap gap-2">
                <Link :href="route('admin.quotes.index')" class="rounded-full border px-3.5 py-1.5 text-sm transition" :class="!filters.status ? 'border-brand-blue bg-brand-blue text-white' : 'border-sidebar-border/70 hover:bg-muted dark:border-sidebar-border'">
                    All <span class="opacity-70">{{ total }}</span>
                </Link>
                <Link v-for="(label, key) in statuses" :key="key" :href="route('admin.quotes.index', { status: key })" class="rounded-full border px-3.5 py-1.5 text-sm capitalize transition" :class="filters.status === key ? 'border-brand-blue bg-brand-blue text-white' : 'border-sidebar-border/70 hover:bg-muted dark:border-sidebar-border'">
                    {{ label }} <span class="opacity-70">{{ counts[key] }}</span>
                </Link>
            </div>

            <!-- table -->
            <div class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <table class="w-full text-sm">
                    <thead class="border-b border-sidebar-border/70 bg-muted/50 text-left text-xs uppercase text-muted-foreground dark:border-sidebar-border">
                        <tr>
                            <th class="px-4 py-3 font-medium">Name</th>
                            <th class="hidden px-4 py-3 font-medium sm:table-cell">Segment</th>
                            <th class="hidden px-4 py-3 font-medium md:table-cell">Service</th>
                            <th class="hidden px-4 py-3 font-medium lg:table-cell">Location</th>
                            <th class="hidden px-4 py-3 font-medium lg:table-cell">Date</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sidebar-border/70 dark:divide-sidebar-border">
                        <tr v-for="q in quotes.data" :key="q.id" class="cursor-pointer transition hover:bg-muted/50" @click="router.visit(route('admin.quotes.show', q.id))">
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ q.name }}</p>
                                <p class="text-xs text-muted-foreground">{{ q.phone }}</p>
                            </td>
                            <td class="hidden px-4 py-3 sm:table-cell">{{ q.segment }}</td>
                            <td class="hidden px-4 py-3 md:table-cell">{{ q.service }}</td>
                            <td class="hidden px-4 py-3 lg:table-cell">{{ q.location }}</td>
                            <td class="hidden whitespace-nowrap px-4 py-3 text-muted-foreground lg:table-cell">{{ q.created_at }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium capitalize" :class="statusClass[q.status]">{{ statuses[q.status] }}</span>
                            </td>
                        </tr>
                        <tr v-if="!quotes.data.length">
                            <td colspan="6" class="px-4 py-12 text-center text-muted-foreground">No requests found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- pagination -->
            <div v-if="quotes.links.length > 3" class="flex flex-wrap gap-1">
                <component
                    :is="link.url ? Link : 'span'"
                    v-for="(link, i) in quotes.links"
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
