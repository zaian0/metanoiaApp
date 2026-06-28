<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Quote {
    id: number;
    salutation: string | null;
    name: string;
    phone: string;
    email: string | null;
    company: string | null;
    segment: string;
    location: string;
    service: string;
    system_type: string | null;
    monthly_bill: string | null;
    timeline: string | null;
    preferred_contact: string | null;
    details: string | null;
    status: string;
    source: string;
    ip: string | null;
    created_at: string;
}

const props = defineProps<{
    quote: Quote;
    labels: Record<string, Record<string, string>>;
    statuses: Record<string, string>;
    whatsapp: string;
}>();

const page = usePage();
const success = computed(() => (page.props.flash as { success?: string } | undefined)?.success);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Quote requests', href: '/dashboard/quotes' },
    { title: props.quote.name, href: `/dashboard/quotes/${props.quote.id}` },
];

const form = useForm({ status: props.quote.status });
const save = () => form.patch(route('admin.quotes.status', props.quote.id), { preserveScroll: true });

const label = (group: string, value: string | null) => (value ? props.labels[group]?.[value] ?? value : '—');

const rows = computed(() => [
    { k: 'Phone / WhatsApp', v: props.quote.phone },
    { k: 'Email', v: props.quote.email || '—' },
    { k: 'Company', v: props.quote.company || '—' },
    { k: 'Segment', v: label('segment', props.quote.segment) },
    { k: 'Location', v: props.quote.location },
    { k: 'Service', v: label('service', props.quote.service) },
    { k: 'System type', v: label('system_type', props.quote.system_type) },
    { k: 'Monthly bill', v: label('monthly_bill', props.quote.monthly_bill) },
    { k: 'Timeline', v: label('timeline', props.quote.timeline) },
    { k: 'Preferred contact', v: label('preferred_contact', props.quote.preferred_contact) },
]);
</script>

<template>
    <Head :title="`Quote — ${quote.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex w-full max-w-3xl flex-1 flex-col gap-5 p-4">
            <Link :href="route('admin.quotes.index')" class="text-sm text-muted-foreground hover:underline">← Back to all requests</Link>

            <div v-if="success" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ success }}
            </div>

            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold">{{ quote.salutation }} {{ quote.name }}</h1>
                    <p class="text-sm text-muted-foreground">Submitted {{ quote.created_at }} · {{ quote.source }} · {{ quote.ip }}</p>
                </div>
            </div>

            <!-- quick actions -->
            <div class="flex flex-wrap gap-2">
                <a :href="`tel:${quote.phone}`" class="rounded-lg border border-sidebar-border/70 px-3.5 py-2 text-sm transition hover:bg-muted dark:border-sidebar-border">Call</a>
                <a :href="whatsapp" target="_blank" rel="noopener" class="rounded-lg border border-emerald-300 bg-emerald-500 px-3.5 py-2 text-sm font-medium text-white transition hover:brightness-95">WhatsApp</a>
                <a v-if="quote.email" :href="`mailto:${quote.email}`" class="rounded-lg border border-sidebar-border/70 px-3.5 py-2 text-sm transition hover:bg-muted dark:border-sidebar-border">Email</a>
            </div>

            <!-- details -->
            <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <dl class="divide-y divide-sidebar-border/70 dark:divide-sidebar-border">
                    <div v-for="r in rows" :key="r.k" class="flex justify-between gap-4 px-5 py-3 text-sm">
                        <dt class="text-muted-foreground">{{ r.k }}</dt>
                        <dd class="text-right font-medium">{{ r.v }}</dd>
                    </div>
                </dl>
            </div>

            <div v-if="quote.details" class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                <p class="mb-1 text-sm text-muted-foreground">Project details</p>
                <p class="whitespace-pre-line text-sm">{{ quote.details }}</p>
            </div>

            <!-- status -->
            <div class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                <p class="mb-3 font-medium">Status</p>
                <form class="flex flex-wrap items-center gap-3" @submit.prevent="save">
                    <select v-model="form.status" class="rounded-lg border border-sidebar-border/70 bg-background px-3 py-2 text-sm dark:border-sidebar-border">
                        <option v-for="(lab, key) in statuses" :key="key" :value="key">{{ lab }}</option>
                    </select>
                    <button type="submit" :disabled="form.processing || form.status === quote.status" class="rounded-lg bg-brand-blue px-4 py-2 text-sm font-medium text-white transition hover:brightness-95 disabled:opacity-50">
                        {{ form.processing ? 'Saving…' : 'Update status' }}
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
