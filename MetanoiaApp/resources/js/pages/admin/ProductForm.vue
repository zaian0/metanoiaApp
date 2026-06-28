<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import InputError from '@/components/InputError.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface Spec {
    label_en: string;
    label_ar: string;
    value: string;
}
interface ExistingImage {
    id: number;
    path: string;
}
interface ProductData {
    id: number;
    product_category_id: number | null;
    slug: string | null;
    name_en: string;
    name_ar: string | null;
    summary_en: string | null;
    summary_ar: string | null;
    description_en: string | null;
    description_ar: string | null;
    tags: string;
    specs: Spec[];
    status: string;
    featured: boolean;
    sort_order: number;
    images: ExistingImage[];
}

const props = defineProps<{
    product: ProductData | null;
    categories: Array<{ id: number; name: string }>;
    statuses: Record<string, string>;
}>();

const isEdit = computed(() => props.product !== null);

const form = useForm({
    product_category_id: props.product?.product_category_id ?? props.categories[0]?.id ?? null,
    name_en: props.product?.name_en ?? '',
    name_ar: props.product?.name_ar ?? '',
    slug: props.product?.slug ?? '',
    summary_en: props.product?.summary_en ?? '',
    summary_ar: props.product?.summary_ar ?? '',
    description_en: props.product?.description_en ?? '',
    description_ar: props.product?.description_ar ?? '',
    tags: props.product?.tags ?? '',
    specs: (props.product?.specs ?? []) as Spec[],
    status: props.product?.status ?? 'draft',
    featured: props.product?.featured ?? false,
    sort_order: props.product?.sort_order ?? 0,
    images: [] as File[],
    removed_images: [] as number[],
});

const existingImages = ref<ExistingImage[]>(props.product?.images ? [...props.product.images] : []);
const newPreviews = ref<string[]>([]);
const fileInput = ref<HTMLInputElement | null>(null);

const onFiles = (e: Event) => {
    const files = Array.from((e.target as HTMLInputElement).files ?? []);
    for (const f of files) {
        form.images.push(f);
        newPreviews.value.push(URL.createObjectURL(f));
    }
    if (fileInput.value) fileInput.value.value = '';
};
const removeNew = (i: number) => {
    form.images.splice(i, 1);
    newPreviews.value.splice(i, 1);
};
const removeExisting = (img: ExistingImage) => {
    form.removed_images.push(img.id);
    existingImages.value = existingImages.value.filter((x) => x.id !== img.id);
};

const addSpec = () => form.specs.push({ label_en: '', label_ar: '', value: '' });
const removeSpec = (i: number) => form.specs.splice(i, 1);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Products', href: '/dashboard/products' },
    { title: isEdit.value ? 'Edit' : 'New', href: '#' },
];

const submit = () => {
    if (isEdit.value && props.product) {
        form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.products.update', props.product.id));
    } else {
        form.post(route('admin.products.store'));
    }
};

const inputClass = 'w-full rounded-lg border border-sidebar-border/70 bg-background px-3 py-2 text-sm outline-none transition focus:border-brand-blue focus:ring-1 focus:ring-brand-blue dark:border-sidebar-border';
</script>

<template>
    <Head :title="isEdit ? 'Edit product' : 'New product'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <form class="mx-auto flex w-full max-w-3xl flex-1 flex-col gap-6 p-4" @submit.prevent="submit">
            <div class="flex items-center justify-between gap-4">
                <h1 class="text-xl font-semibold">{{ isEdit ? 'Edit product' : 'New product' }}</h1>
                <Link :href="route('admin.products.index')" class="text-sm text-muted-foreground hover:underline">← Back</Link>
            </div>

            <!-- Category + slug -->
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Category</label>
                    <select v-model="form.product_category_id" :class="inputClass">
                        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                    </select>
                    <InputError :message="form.errors.product_category_id" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Slug <span class="font-normal text-muted-foreground">(optional)</span></label>
                    <input v-model="form.slug" type="text" :class="inputClass" placeholder="auto from English name" />
                    <InputError :message="form.errors.slug" class="mt-1" />
                </div>
            </div>

            <!-- Names -->
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Name (English)</label>
                    <input v-model="form.name_en" type="text" :class="inputClass" placeholder="Mono PERC 580W module" />
                    <InputError :message="form.errors.name_en" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Name (Arabic)</label>
                    <input v-model="form.name_ar" type="text" dir="rtl" :class="inputClass" placeholder="لوح أحادي 580 وات" />
                    <InputError :message="form.errors.name_ar" class="mt-1" />
                </div>
            </div>

            <!-- Summaries -->
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Summary (English) <span class="font-normal text-muted-foreground">(card text)</span></label>
                    <textarea v-model="form.summary_en" rows="2" maxlength="500" :class="inputClass" />
                    <InputError :message="form.errors.summary_en" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Summary (Arabic)</label>
                    <textarea v-model="form.summary_ar" rows="2" dir="rtl" maxlength="500" :class="inputClass" />
                    <InputError :message="form.errors.summary_ar" class="mt-1" />
                </div>
            </div>

            <!-- Descriptions -->
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Description (English) <span class="font-normal text-muted-foreground">(Markdown)</span></label>
                    <textarea v-model="form.description_en" rows="8" :class="[inputClass, 'font-mono text-[13px]']" />
                    <InputError :message="form.errors.description_en" class="mt-1" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Description (Arabic) <span class="font-normal text-muted-foreground">(Markdown)</span></label>
                    <textarea v-model="form.description_ar" rows="8" dir="rtl" :class="[inputClass, 'text-[13px]']" />
                    <InputError :message="form.errors.description_ar" class="mt-1" />
                </div>
            </div>

            <!-- Tags -->
            <div>
                <label class="mb-1.5 block text-sm font-medium">Tags <span class="font-normal text-muted-foreground">(comma separated)</span></label>
                <input v-model="form.tags" type="text" :class="inputClass" placeholder="On-grid, 1500V, Industrial" />
                <InputError :message="form.errors.tags" class="mt-1" />
            </div>

            <!-- Images -->
            <div>
                <label class="mb-1.5 block text-sm font-medium">Images</label>
                <div class="flex flex-wrap gap-3">
                    <div v-for="img in existingImages" :key="'e' + img.id" class="group relative h-20 w-24 overflow-hidden rounded-lg border border-sidebar-border/70 dark:border-sidebar-border">
                        <img :src="img.path" alt="" class="h-full w-full object-cover" />
                        <button type="button" class="absolute right-1 top-1 flex h-5 w-5 items-center justify-center rounded-full bg-black/60 text-xs text-white" aria-label="Remove" @click="removeExisting(img)">×</button>
                    </div>
                    <div v-for="(src, i) in newPreviews" :key="'n' + i" class="group relative h-20 w-24 overflow-hidden rounded-lg border border-brand-blue/40">
                        <img :src="src" alt="" class="h-full w-full object-cover" />
                        <button type="button" class="absolute right-1 top-1 flex h-5 w-5 items-center justify-center rounded-full bg-black/60 text-xs text-white" aria-label="Remove" @click="removeNew(i)">×</button>
                    </div>
                    <button type="button" class="flex h-20 w-24 flex-col items-center justify-center gap-1 rounded-lg border border-dashed border-sidebar-border/70 text-xs text-muted-foreground transition hover:border-brand-blue hover:text-brand-blue dark:border-sidebar-border" @click="fileInput?.click()">
                        <span class="text-lg leading-none">+</span> Add
                    </button>
                </div>
                <input ref="fileInput" type="file" accept="image/png,image/jpeg,image/webp" multiple class="hidden" @change="onFiles" />
                <p class="mt-1 text-xs text-muted-foreground">JPG, PNG, or WebP · up to 4 MB each. First image is the cover.</p>
                <InputError :message="form.errors.images" class="mt-1" />
            </div>

            <!-- Specs -->
            <div class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                <div class="mb-3 flex items-center justify-between">
                    <p class="text-sm font-medium">Specifications</p>
                    <button type="button" class="text-sm text-brand-blue hover:underline dark:text-blue-400" @click="addSpec">+ Add row</button>
                </div>
                <div v-if="form.specs.length" class="flex flex-col gap-2">
                    <div v-for="(s, i) in form.specs" :key="i" class="grid grid-cols-[1fr_1fr_1fr_auto] gap-2">
                        <input v-model="s.label_en" type="text" :class="inputClass" placeholder="Label (EN)" />
                        <input v-model="s.label_ar" type="text" dir="rtl" :class="inputClass" placeholder="التسمية" />
                        <input v-model="s.value" type="text" :class="inputClass" placeholder="Value" />
                        <button type="button" class="px-2 text-red-600 hover:underline dark:text-red-400" aria-label="Remove row" @click="removeSpec(i)">×</button>
                    </div>
                </div>
                <p v-else class="text-sm text-muted-foreground">No specs yet. Add rows like Power / 580 W.</p>
            </div>

            <!-- Publishing -->
            <div class="grid gap-5 rounded-xl border border-sidebar-border/70 p-5 sm:grid-cols-3 dark:border-sidebar-border">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Status</label>
                    <select v-model="form.status" :class="inputClass">
                        <option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Sort order</label>
                    <input v-model="form.sort_order" type="number" min="0" :class="inputClass" />
                </div>
                <div class="flex items-end">
                    <label class="flex cursor-pointer items-center gap-2 text-sm font-medium">
                        <input v-model="form.featured" type="checkbox" class="h-4 w-4 rounded border-sidebar-border/70 text-brand-blue" />
                        Featured
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-brand-blue px-5 py-2.5 text-sm font-medium text-white transition hover:brightness-95 disabled:opacity-50">
                    {{ form.processing ? 'Saving…' : isEdit ? 'Save changes' : 'Create product' }}
                </button>
                <Link :href="route('admin.products.index')" class="rounded-lg border border-sidebar-border/70 px-5 py-2.5 text-sm transition hover:bg-muted dark:border-sidebar-border">Cancel</Link>
            </div>
        </form>
    </AppLayout>
</template>
