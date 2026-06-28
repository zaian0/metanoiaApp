<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { site } from '@/lib/site';
import Toast from '@/components/Toast.vue';

const page = usePage();
const open = ref(false);

// Dark mode is dashboard-only — the public marketing site always renders light.
onMounted(() => document.documentElement.classList.remove('dark'));

const isActive = (path: string) =>
    path === '/' ? page.url === '/' : page.url.startsWith(path);

const year = new Date().getFullYear();
</script>

<template>
    <div class="min-h-screen bg-brand-snow font-body text-brand-navy antialiased">
        <Toast />

        <!-- Header -->
        <header class="sticky top-0 z-50 border-b border-brand-border bg-white/90 backdrop-blur">
            <div class="container-x flex h-[72px] items-center justify-between">
                <Link href="/" class="flex shrink-0 items-center" aria-label="Metanoia Energy — home">
                    <img src="/brand/logo-primary.png" alt="Metanoia Energy" class="h-9 w-auto" />
                </Link>

                <nav class="hidden items-center gap-9 lg:flex" aria-label="Primary">
                    <Link href="/" class="nav-link" :class="{ 'is-active': isActive('/') }">Home</Link>
                    <Link href="/about" class="nav-link" :class="{ 'is-active': isActive('/about') }">About</Link>
                    <a href="/#solutions" class="nav-link">Solutions</a>
                    <Link href="/articles" class="nav-link" :class="{ 'is-active': isActive('/articles') }">Articles</Link>
                    <Link href="/contact" class="nav-link" :class="{ 'is-active': isActive('/contact') }">Contact</Link>
                </nav>

                <div class="hidden items-center gap-3 lg:flex">
                    <a :href="`tel:+${site.phoneIntl}`" class="nav-link">{{ site.phone }}</a>
                    <Link href="/quote" class="btn btn--primary !px-5 !py-2.5 !text-sm">Get a Quote</Link>
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
                    <Link href="/" class="nav-link py-3" :class="{ 'is-active': isActive('/') }" @click="open = false">Home</Link>
                    <Link href="/about" class="nav-link py-3" :class="{ 'is-active': isActive('/about') }" @click="open = false">About</Link>
                    <a href="/#solutions" class="nav-link py-3" @click="open = false">Solutions</a>
                    <Link href="/articles" class="nav-link py-3" :class="{ 'is-active': isActive('/articles') }" @click="open = false">Articles</Link>
                    <Link href="/contact" class="nav-link py-3" :class="{ 'is-active': isActive('/contact') }" @click="open = false">Contact</Link>
                    <Link href="/quote" class="btn btn--primary mt-3" @click="open = false">Get a Quote</Link>
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
                        <p class="mt-5 max-w-xs text-sm leading-relaxed text-brand-beige/70">
                            Integrated solar energy solutions for factories, farms, and commercial facilities across
                            Egypt — engineered for performance, reliability, and real return on investment.
                        </p>
                        <p class="mt-4 font-display text-sm font-semibold tracking-wide text-brand-yellow">{{ site.tagline }}</p>
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
                        <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white">Explore</h3>
                        <ul class="mt-5 space-y-3 text-sm">
                            <li><Link href="/" class="footer-link">Home</Link></li>
                            <li><Link href="/about" class="footer-link">About Us</Link></li>
                            <li><a href="/#solutions" class="footer-link">Solutions</a></li>
                            <li><Link href="/articles" class="footer-link">Articles</Link></li>
                            <li><Link href="/contact" class="footer-link">Contact</Link></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white">Get a quote</h3>
                        <ul class="mt-5 space-y-3 text-sm">
                            <li><Link href="/quote" class="footer-link">Request a quotation</Link></li>
                            <li><a :href="site.whatsappMsg" target="_blank" rel="noopener" class="footer-link">WhatsApp us</a></li>
                            <li><a :href="`tel:+${site.phoneIntl}`" class="footer-link">Call {{ site.phone }}</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white">Get in touch</h3>
                        <ul class="mt-5 space-y-4 text-sm">
                            <li class="flex gap-3 text-brand-beige/70">
                                <span>{{ site.address }}</span>
                            </li>
                            <li><a :href="`mailto:${site.email}`" class="footer-link">{{ site.email }}</a></li>
                            <li class="text-brand-beige/70">{{ site.hours }}</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-14 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-7 text-sm text-brand-beige/60 sm:flex-row">
                    <p>© {{ year }} {{ site.name }}. All rights reserved.</p>
                    <p>TRN {{ site.trn }} · Built in Sadat City, Egypt</p>
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
