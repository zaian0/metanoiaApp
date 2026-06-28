<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import InputError from '@/components/InputError.vue';
import { categoryIcon } from '@/lib/categoryIcons';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

interface CategoryData {
    id: number;
    name_en: string;
    name_ar: string | null;
    slug: string | null;
    icon: string | null;
    sort_order: number;
}

const props = defineProps<{ category: CategoryData | null; icons: string[] }>();

const isEdit = computed(() => props.category !== null);

const form = useForm({
    name_en: props.category?.name_en ?? '',
    name_ar: props.category?.name_ar ?? '',
    slug: props.category?.slug ?? '',
    icon: props.category?.icon ?? 'box',
    sort_order: props.category?.sort_order ?? 0,
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Categories', href: '/dashboard/product-categories' },
    { title: isEdit.value ? 'Edit' : 'New', href: '#' },
];

const submit = () => {
    if (isEdit.value && props.category) {
        form.put(route('admin.product-categories.update', props.category.id));
    } else {
        form.post(route('admin.product-categories.store'));
    }
};

const inputClass = 'w-full rounded-lg border border-sidebar-border/70 bg-background px-3 py-2 text-sm outline-none transition focus:border-brand-blue focus:ring-1 focus:ring-brand-blue dark:border-sidebar-border';
</script>

<template>
    <Head :title="isEdit ? 'Edit category' : 'New category'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <form class="mx-auto flex w-full max-w-2xl flex-1 flex-col gap-6 p-4" @submit.prevent="submit">
            <div class="flex items-center justify-between gap-4">
                <h1 class="text-xl font-semibold">{{ isEdit ? 'Edit category' : 'New category' }}</h1>
                <Link :href="route('admin.product-categories.index')" class="text-sm text-muted-foreground hover:underline">← Back</Link>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Name (English)</label>
                    <input v-model="form.name_en" type="text" :class="inputClass" placeholder="Solar Panels" />
                    <InputError :message="form.errors.name_en" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Name (Arabic)</label>
                    <input v-model="form.name_ar" type="text" dir="rtl" :class="inputClass" placeholder="الألواح الشمسية" />
                    <InputError :message="form.errors.name_ar" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Slug <span class="font-normal text-muted-foreground">(optional)</span></label>
                    <input v-model="form.slug" type="text" :class="inputClass" placeholder="auto from name" />
                    <InputError :message="form.errors.slug" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Sort order</label>
                    <input v-model="form.sort_order" type="number" min="0" :class="inputClass" />
                    <InputError :message="form.errors.sort_order" class="mt-1" />
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium">Icon</label>
                <div class="flex flex-wrap gap-2">
                    <button
                        v-for="ic in icons"
                        :key="ic"
                        type="button"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-lg border-2 transition"
                        :class="form.icon === ic ? 'border-brand-blue bg-brand-blue/10 text-brand-blue' : 'border-sidebar-border/70 text-muted-foreground hover:border-brand-blue/50 dark:border-sidebar-border'"
                        :aria-label="ic"
                        @click="form.icon = ic"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" v-html="categoryIcon(ic)" />
                    </button>
                </div>
                <InputError :message="form.errors.icon" class="mt-1" />
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-blue px-5 py-2.5 text-sm font-medium text-white transition hover:brightness-95 disabled:opacity-50">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Save changes' : 'Create category' }}
                </button>
                <Link :href="route('admin.product-categories.index')" class="rounded-lg border border-sidebar-border/70 px-5 py-2.5 text-sm transition hover:bg-muted dark:border-sidebar-border">Cancel</Link>
            </div>
        </form>
    </AppLayout>
</template>
