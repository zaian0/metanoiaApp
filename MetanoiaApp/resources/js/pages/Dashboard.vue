<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Recent {
    id: number;
    name: string;
    segment: string;
    service: string;
    status: string;
    created_at: string;
}

defineProps<{
    stats: { total: number; new: number; week: number };
    recent: Recent[];
    statuses: Record<string, string>;
}>();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Dashboard', href: '/dashboard' }];

const statusClass: Record<string, string> = {
    new: 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
    contacted: 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300',
    quoted: 'bg-violet-100 text-violet-700 dark:bg-violet-500/15 dark:text-violet-300',
    closed: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-6 p-4">
            <div>
                <h1 class="text-xl font-semibold">Overview</h1>
                <p class="text-sm text-muted-foreground">Quote requests from the website.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                    <p class="text-sm text-muted-foreground">Total requests</p>
                    <p class="mt-1 text-3xl font-semibold">{{ stats.total }}</p>
                </div>
                <div class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                    <p class="text-sm text-muted-foreground">New</p>
                    <p class="mt-1 text-3xl font-semibold text-brand-blue dark:text-blue-400">{{ stats.new }}</p>
                </div>
                <div class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                    <p class="text-sm text-muted-foreground">This week</p>
                    <p class="mt-1 text-3xl font-semibold">{{ stats.week }}</p>
                </div>
            </div>

            <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <div class="flex items-center justify-between border-b border-sidebar-border/70 px-5 py-3 dark:border-sidebar-border">
                    <h2 class="font-medium">Recent requests</h2>
                    <Link :href="route('admin.quotes.index')" class="text-sm text-brand-blue hover:underline dark:text-blue-400">View all →</Link>
                </div>
                <div v-if="recent.length" class="divide-y divide-sidebar-border/70 dark:divide-sidebar-border">
                    <Link v-for="q in recent" :key="q.id" :href="route('admin.quotes.show', q.id)" class="flex items-center justify-between px-5 py-3 transition hover:bg-muted/50">
                        <div class="min-w-0">
                            <p class="truncate font-medium">{{ q.name }}</p>
                            <p class="truncate text-sm text-muted-foreground">{{ q.segment }} · {{ q.service }} · {{ q.created_at }}</p>
                        </div>
                        <span class="ml-3 shrink-0 rounded-full px-2.5 py-1 text-xs font-medium capitalize" :class="statusClass[q.status]">{{ statuses[q.status] }}</span>
                    </Link>
                </div>
                <p v-else class="px-5 py-10 text-center text-sm text-muted-foreground">No quote requests yet.</p>
            </div>
        </div>
    </AppLayout>
</template>
