<script setup lang="ts">
import LanguageSwitcher from '@/components/LanguageSwitcher.vue';
import Toast from '@/components/Toast.vue';
import { useTranslations } from '@/composables/useTranslations';
import { site } from '@/lib/site';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';

const { t, locale, localePath, isActivePath } = useTranslations();
const page = usePage();
const open = ref(false);

// Dark mode is dashboard-only — the public marketing site always renders light.
onMounted(() => document.documentElement.classList.remove('dark'));

const solutionsHref = computed(() => `${localePath('home')}#solutions`);

const nav = computed(() => [
    { label: t('nav.home'), href: localePath('home'), active: isActivePath('home') },
    { label: t('nav.about'), href: localePath('about'), active: isActivePath('about') },
    { label: t('nav.solutions'), href: solutionsHref.value, active: false },
    { label: t('nav.products'), href: localePath('products'), active: isActivePath('products') },
    { label: t('nav.articles'), href: localePath('articles'), active: isActivePath('articles') },
    { label: t('nav.contact'), href: localePath('contact'), active: isActivePath('contact') },
]);

const alternates = computed(
    () => (page.props.alternates as { en: string; ar: string } | undefined) ?? { en: '/', ar: '/ar' },
);

const year = new Date().getFullYear();
</script>

<template>
    <Head>
        <link rel="alternate" hreflang="en" :href="alternates.en" head-key="hreflang-en" />
        <link rel="alternate" hreflang="ar" :href="alternates.ar" head-key="hreflang-ar" />
        <link rel="alternate" hreflang="x-default" :href="alternates.en" head-key="hreflang-x" />
        <meta property="og:locale" :content="locale === 'ar' ? 'ar_EG' : 'en_US'" head-key="og-locale" />
    </Head>

    <div class="min-h-screen bg-brand-snow font-body text-brand-navy antialiased">
        <Toast />

        <!-- Header -->
        <header class="sticky top-0 z-50 border-b border-brand-border bg-white/90 backdrop-blur">
            <div class="container-x flex h-[72px] items-center justify-between">
                <Link :href="localePath('home')" class="flex shrink-0 items-center" aria-label="Metanoia Energy">
                    <img src="/brand/logo-primary.png" alt="Metanoia Energy" class="h-9 w-auto" />
                </Link>

                <nav class="hidden items-center gap-9 lg:flex" aria-label="Primary">
                    <component
                        :is="item.href.includes('#') ? 'a' : Link"
                        v-for="item in nav"
                        :key="item.label"
                        :href="item.href"
                        class="nav-link"
                        :class="{ 'is-active': item.active }"
                    >
                        {{ item.label }}
                    </component>
                </nav>

                <div class="hidden items-center gap-4 lg:flex">
                    <LanguageSwitcher />
                    <a :href="`tel:+${site.phoneIntl}`" class="nav-link">{{ site.phone }}</a>
                    <Link :href="localePath('quote')" class="btn btn--primary !px-5 !py-2.5 !text-sm">{{ t('actions.get_quote') }}</Link>
                </div>

                <button
                    type="button"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-brand-border text-brand-navy lg:hidden"
                    :aria-expanded="open"
                    aria-label="Toggle menu"
                    @click="open = !open"
                >
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <line x1="3" y1="12" x2="21" y2="12" />
                        <line x1="3" y1="18" x2="21" y2="18" />
                    </svg>
                </button>
            </div>

            <div v-show="open" class="border-t border-brand-border bg-white lg:hidden">
                <nav class="container-x flex flex-col gap-1 py-4" aria-label="Mobile">
                    <component
                        :is="item.href.includes('#') ? 'a' : Link"
                        v-for="item in nav"
                        :key="item.label"
                        :href="item.href"
                        class="nav-link py-3"
                        :class="{ 'is-active': item.active }"
                        @click="open = false"
                    >
                        {{ item.label }}
                    </component>
                    <div class="py-3"><LanguageSwitcher /></div>
                    <Link :href="localePath('quote')" class="btn btn--primary mt-3" @click="open = false">{{ t('actions.get_quote') }}</Link>
                </nav>
            </div>
        </header>

        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-brand-navy text-brand-beige">
            <div class="container-x py-16">
                <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr]">
                    <div>
                        <img src="/brand/logo-reversed.png" alt="Metanoia Energy" class="h-14 w-14 rounded-2xl" />
                        <p class="mt-5 max-w-xs text-sm leading-relaxed text-brand-beige/70">{{ t('footer.intro') }}</p>
                        <p class="mt-4 font-display text-sm font-semibold tracking-wide text-brand-yellow">{{ t('brand.tagline') }}</p>
                        <div class="mt-6 flex items-center gap-3">
                            <a :href="site.social.instagram" target="_blank" rel="noopener" class="social-btn" aria-label="Instagram">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5" /><circle cx="12" cy="12" r="4" /><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" /></svg>
                            </a>
                            <a :href="site.social.tiktok" target="_blank" rel="noopener" class="social-btn" aria-label="TikTok">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16.5 3c.3 2.2 1.6 3.6 3.7 3.8v2.5c-1.2.1-2.4-.2-3.5-.8v6.1c0 3.2-2.4 5.6-5.5 5.6A5.4 5.4 0 0 1 5.7 14c0-3 2.5-5.4 5.6-5.3v2.6c-.4-.1-.8-.2-1.2-.1-1.3.1-2.3 1.2-2.2 2.5 0 1.4 1.1 2.5 2.5 2.5 1.5 0 2.6-1.1 2.6-2.7V3h3.5Z" /></svg>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white">{{ t('footer.explore') }}</h3>
                        <ul class="mt-5 space-y-3 text-sm">
                            <li><Link :href="localePath('home')" class="footer-link">{{ t('nav.home') }}</Link></li>
                            <li><Link :href="localePath('about')" class="footer-link">{{ t('nav.about') }}</Link></li>
                            <li><a :href="solutionsHref" class="footer-link">{{ t('nav.solutions') }}</a></li>
                            <li><Link :href="localePath('products')" class="footer-link">{{ t('nav.products') }}</Link></li>
                            <li><Link :href="localePath('articles')" class="footer-link">{{ t('nav.articles') }}</Link></li>
                            <li><Link :href="localePath('contact')" class="footer-link">{{ t('nav.contact') }}</Link></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white">{{ t('footer.get_a_quote') }}</h3>
                        <ul class="mt-5 space-y-3 text-sm">
                            <li><Link :href="localePath('quote')" class="footer-link">{{ t('actions.request_quotation') }}</Link></li>
                            <li><a :href="site.whatsappMsg" target="_blank" rel="noopener" class="footer-link">{{ t('actions.whatsapp_us') }}</a></li>
                            <li><a :href="`tel:+${site.phoneIntl}`" class="footer-link">{{ t('actions.call') }} {{ site.phone }}</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white">{{ t('footer.get_in_touch') }}</h3>
                        <ul class="mt-5 space-y-4 text-sm">
                            <li class="flex gap-3 text-brand-beige/70"><span>{{ site.address }}</span></li>
                            <li><a :href="`mailto:${site.email}`" class="footer-link">{{ site.email }}</a></li>
                            <li class="text-brand-beige/70">{{ site.hours }}</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-14 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-7 text-sm text-brand-beige/60 sm:flex-row">
                    <p>© {{ year }} {{ site.name }}. {{ t('footer.rights') }}</p>
                    <p>{{ t('footer.trn') }} {{ site.trn }} · {{ t('footer.built_in') }}</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.footer-link {
    display: inline-block;
    color: rgb(244 241 234 / 0.72);
    transition: color 0.15s ease;
}
.footer-link:hover {
    color: #fff;
}
.social-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 999px;
    background: rgb(255 255 255 / 0.08);
    color: #f4f1ea;
    transition: background-color 0.15s ease, transform 0.15s ease;
}
.social-btn:hover {
    background: #1b499f;
    color: #fff;
    transform: translateY(-2px);
}
.social-btn svg {
    width: 18px;
    height: 18px;
}
</style>
