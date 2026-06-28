<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useTranslations } from '@/composables/useTranslations';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { site } from '@/lib/site';

const { t, tList, localePath } = useTranslations();

const props = defineProps<{
    options: {
        salutations: Record<string, string>;
        segments: Record<string, string>;
        services: Record<string, string>;
        systemTypes: Record<string, string>;
        monthlyBills: Record<string, string>;
        timelines: Record<string, string>;
        contactMethods: Record<string, string>;
    };
}>();

const form = useForm({
    salutation: '',
    name: '',
    phone: '',
    email: '',
    company: '',
    segment: '',
    location: '',
    service: '',
    system_type: '',
    monthly_bill: '',
    timeline: '',
    preferred_contact: '',
    details: '',
    website: '', // honeypot
});

const submit = () =>
    form.post(localePath('quote'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });

const serviceIcons: Record<string, string> = {
    supply: 'M3 7l9-4 9 4-9 4-9-4Z',
    install: 'M14.7 6.3a4 4 0 0 0-5.4 5.4l-6 6 2 2 6-6a4 4 0 0 0 5.4-5.4l-2.3 2.3-2-2 2.3-2.3Z',
    both: 'M20 6 9 17l-5-5',
};

const stepIcons = [
    'M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z',
    'm9 11 3 3L22 4M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11',
    'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Zm0 0v6h6',
];
const steps = computed(() => tList<string>('quote.steps').map((label, i) => ({ label, icon: stepIcons[i] })));

const whatsappHref = computed(() => {
    const f = form;
    const lines = [
        t('quote.wa.greeting'),
        `${t('quote.wa.name')}: ${props.options.salutations[f.salutation] ?? f.salutation} ${f.name}`.trim(),
        f.phone ? `${t('quote.wa.phone')}: ${f.phone}` : '',
        f.company ? `${t('quote.wa.company')}: ${f.company}` : '',
        f.segment ? `${t('quote.wa.segment')}: ${props.options.segments[f.segment] ?? f.segment}` : '',
        f.location ? `${t('quote.wa.location')}: ${f.location}` : '',
        f.service ? `${t('quote.wa.service')}: ${props.options.services[f.service] ?? f.service}` : '',
        f.system_type ? `${t('quote.wa.system')}: ${props.options.systemTypes[f.system_type] ?? ''}` : '',
        f.details ? `${t('quote.wa.details')}: ${f.details}` : '',
    ].filter(Boolean);
    return `https://wa.me/${site.phoneIntl}?text=` + encodeURIComponent(lines.join('\n'));
});
</script>

<template>
    <Head :title="t('quote.meta_title')">
        <meta name="description" :content="t('quote.meta_description')" />
    </Head>

    <PublicLayout>
        <!-- HERO -->
        <section class="bg-brand-beige/50">
            <div class="container-x max-w-3xl py-14 lg:py-16">
                <p class="eyebrow">{{ t('quote.hero.eyebrow') }}</p>
                <h1 class="mt-5 font-display text-4xl font-extrabold leading-[1.1] tracking-tight text-brand-blue">{{ t('quote.hero.title') }}</h1>
                <p class="lead mt-4">{{ t('quote.hero.lead') }}</p>
            </div>
        </section>

        <section class="section">
            <div class="container-x max-w-3xl">
                <!-- steps -->
                <div class="mb-8 grid grid-cols-3 gap-3">
                    <div v-for="(s, i) in steps" :key="i" class="rounded-card border border-brand-border bg-white p-4">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-brand-blue/10 text-brand-blue">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path :d="s.icon" /></svg>
                        </span>
                        <p class="mt-2 font-display text-sm font-semibold text-brand-navy">{{ s.label }}</p>
                    </div>
                </div>

                <form class="rounded-card border border-brand-border bg-white p-6 md:p-8" @submit.prevent="submit">
                    <!-- About you -->
                    <h2 class="q-section">{{ t('quote.sections.about_you') }}</h2>
                    <div class="grid gap-x-5 sm:grid-cols-2">
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.title') }}</label>
                            <select v-model="form.salutation" class="q-ctrl">
                                <option value="">{{ t('quote.dash') }}</option>
                                <option v-for="(label, key) in options.salutations" :key="key" :value="key">{{ label }}</option>
                            </select>
                        </div>
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.full_name') }} <span class="q-req">*</span></label>
                            <input v-model="form.name" type="text" class="q-ctrl" :placeholder="t('quote.placeholders.name')" />
                            <p v-if="form.errors.name" class="q-err">{{ form.errors.name }}</p>
                        </div>
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.phone') }} <span class="q-req">*</span></label>
                            <input v-model="form.phone" type="tel" class="q-ctrl" :placeholder="t('quote.placeholders.phone')" />
                            <p v-if="form.errors.phone" class="q-err">{{ form.errors.phone }}</p>
                        </div>
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.email') }}</label>
                            <input v-model="form.email" type="email" class="q-ctrl" :placeholder="t('quote.placeholders.email')" />
                            <p v-if="form.errors.email" class="q-err">{{ form.errors.email }}</p>
                        </div>
                        <div class="q-field sm:col-span-2">
                            <label class="q-lbl">{{ t('quote.labels.company') }}</label>
                            <input v-model="form.company" type="text" class="q-ctrl" :placeholder="t('quote.placeholders.company')" />
                        </div>
                    </div>

                    <!-- Business -->
                    <h2 class="q-section">{{ t('quote.sections.your_business') }}</h2>
                    <div class="grid gap-x-5 sm:grid-cols-2">
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.i_am_a') }} <span class="q-req">*</span></label>
                            <select v-model="form.segment" class="q-ctrl">
                                <option value="">{{ t('quote.select') }}</option>
                                <option v-for="(label, key) in options.segments" :key="key" :value="key">{{ label }}</option>
                            </select>
                            <p v-if="form.errors.segment" class="q-err">{{ form.errors.segment }}</p>
                        </div>
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.site_location') }} <span class="q-req">*</span></label>
                            <input v-model="form.location" type="text" class="q-ctrl" :placeholder="t('quote.placeholders.location')" />
                            <p v-if="form.errors.location" class="q-err">{{ form.errors.location }}</p>
                        </div>
                    </div>

                    <!-- Needs -->
                    <h2 class="q-section">{{ t('quote.sections.what_you_need') }}</h2>
                    <div class="q-field">
                        <label class="q-lbl">{{ t('quote.labels.service_needed') }} <span class="q-req">*</span></label>
                        <div class="grid grid-cols-3 gap-2">
                            <button v-for="(label, key) in options.services" :key="key" type="button" class="q-seg" :class="{ 'q-seg--on': form.service === key }" @click="form.service = key">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path :d="serviceIcons[key]" /></svg>
                                {{ t('quote.service_short.' + key) }}
                            </button>
                        </div>
                        <p v-if="form.errors.service" class="q-err">{{ form.errors.service }}</p>
                    </div>
                    <div class="grid gap-x-5 sm:grid-cols-2">
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.system_type') }}</label>
                            <select v-model="form.system_type" class="q-ctrl">
                                <option value="">{{ t('quote.select') }}</option>
                                <option v-for="(label, key) in options.systemTypes" :key="key" :value="key">{{ label }}</option>
                            </select>
                        </div>
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.monthly_bill') }}</label>
                            <select v-model="form.monthly_bill" class="q-ctrl">
                                <option value="">{{ t('quote.select') }}</option>
                                <option v-for="(label, key) in options.monthlyBills" :key="key" :value="key">{{ label }}</option>
                            </select>
                        </div>
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.when_to_start') }}</label>
                            <select v-model="form.timeline" class="q-ctrl">
                                <option value="">{{ t('quote.select') }}</option>
                                <option v-for="(label, key) in options.timelines" :key="key" :value="key">{{ label }}</option>
                            </select>
                        </div>
                        <div class="q-field">
                            <label class="q-lbl">{{ t('quote.labels.preferred_contact') }}</label>
                            <select v-model="form.preferred_contact" class="q-ctrl">
                                <option value="">{{ t('quote.select') }}</option>
                                <option v-for="(label, key) in options.contactMethods" :key="key" :value="key">{{ label }}</option>
                            </select>
                        </div>
                        <div class="q-field sm:col-span-2">
                            <label class="q-lbl">{{ t('quote.labels.project_details') }}</label>
                            <textarea v-model="form.details" rows="3" class="q-ctrl" :placeholder="t('quote.placeholders.details')"></textarea>
                        </div>
                    </div>

                    <!-- honeypot -->
                    <div class="q-hp" aria-hidden="true">
                        <label>Website<input v-model="form.website" type="text" tabindex="-1" autocomplete="off" /></label>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <button type="submit" class="btn btn--primary" :disabled="form.processing">
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m22 2-7 20-4-9-9-4Z" /><path d="M22 2 11 13" /></svg>
                            {{ form.processing ? t('quote.buttons.sending') : t('quote.buttons.submit') }}
                        </button>
                        <a :href="whatsappHref" target="_blank" rel="noopener" class="btn btn--wa">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Z" /></svg>
                            {{ t('quote.buttons.whatsapp') }}
                        </a>
                    </div>
                    <p class="mt-3 text-xs text-brand-muted">{{ t('quote.privacy') }}</p>
                </form>
            </div>
        </section>
    </PublicLayout>
</template>

<style>
.q-field {
    margin-bottom: 1.1rem;
}
.q-lbl {
    display: block;
    margin-bottom: 0.4rem;
    font-family: Outfit, sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    color: #101827;
}
.q-req {
    color: #1b499f;
}
.q-ctrl {
    width: 100%;
    border: 1px solid #e6e8ef;
    border-radius: 10px;
    background: #fff;
    padding: 0.7rem 0.85rem;
    font-family: Inter, sans-serif;
    font-size: 0.95rem;
    color: #101827;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.q-ctrl::placeholder {
    color: #9aa3b2;
}
.q-ctrl:focus {
    outline: none;
    border-color: #1b499f;
    box-shadow: 0 0 0 3px rgb(27 73 159 / 0.12);
}
textarea.q-ctrl {
    min-height: 96px;
    resize: vertical;
}
select.q-ctrl {
    appearance: none;
    -webkit-appearance: none;
    padding-right: 2.25rem;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%231B499F' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 24 24'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.85rem center;
}
[dir='rtl'] select.q-ctrl {
    padding-right: 0.85rem;
    padding-left: 2.25rem;
    background-position: left 0.85rem center;
}
.q-seg {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    cursor: pointer;
    border: 1px solid #e6e8ef;
    border-radius: 10px;
    padding: 0.7rem 0.5rem;
    font-family: Outfit, sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    color: #101827;
    transition: all 0.15s ease;
}
.q-seg--on {
    border-color: #1b499f;
    background: rgb(27 73 159 / 0.06);
    color: #1b499f;
    box-shadow: inset 0 0 0 1px #1b499f;
}
.q-err {
    margin-top: 0.3rem;
    font-size: 0.8rem;
    color: #b3261e;
}
.q-section {
    margin: 1.75rem 0 1rem;
    border-top: 1px solid #e6e8ef;
    padding-top: 1.5rem;
    font-family: Outfit, sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: #1b499f;
}
.q-section:first-of-type {
    margin-top: 0;
    border-top: 0;
    padding-top: 0;
}
.q-hp {
    position: absolute;
    left: -9999px;
    width: 1px;
    height: 1px;
    overflow: hidden;
}
</style>
