import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

type Messages = Record<string, unknown>;

/**
 * Lightweight i18n for the public site. UI strings for the active locale are shared
 * from Laravel (`lang/{locale}/site.php`) via Inertia, then looked up by dot-path.
 *
 * `t()` returns whatever the key resolves to — a string, an array, or an object —
 * so structured content (e.g. a list of cards) can live in the lang files too.
 */
export function useTranslations() {
    const page = usePage();

    const locale = computed(() => (page.props.locale as string) ?? 'en');
    const direction = computed(() => (page.props.direction as string) ?? 'ltr');
    const isRtl = computed(() => direction.value === 'rtl');
    const messages = computed(() => (page.props.translations as Messages) ?? {});

    function resolve(key: string): unknown {
        return key.split('.').reduce<unknown>((acc, part) => {
            if (acc && typeof acc === 'object') {
                return (acc as Record<string, unknown>)[part];
            }
            return undefined;
        }, messages.value);
    }

    /** Translate a dot-path key. Returns `fallback` (or the key) when missing. */
    function t(key: string, fallback?: string): string {
        const value = resolve(key);
        return typeof value === 'string' ? value : (fallback ?? key);
    }

    /** Translate a key expected to hold an array (e.g. a list of feature cards). */
    function tList<T = Record<string, string>>(key: string): T[] {
        const value = resolve(key);
        return Array.isArray(value) ? (value as T[]) : [];
    }

    /** Translate a key expected to hold an object/map. */
    function tObj<T = Record<string, string>>(key: string): T {
        const value = resolve(key);
        return (value && typeof value === 'object' ? value : {}) as T;
    }

    // Public page paths (English at root; Arabic gets a /ar prefix). Built as plain
    // strings so they work identically in SSR and the browser without Ziggy.
    const PUBLIC_PATHS: Record<string, string> = {
        home: '/',
        about: '/about',
        contact: '/contact',
        articles: '/articles',
        quote: '/quote',
    };

    /** Locale-aware path for a public route, e.g. localePath('articles', '/' + slug). */
    function localePath(key: string, sub = ''): string {
        const base = PUBLIC_PATHS[key] ?? '/';
        const path = base === '/' ? '' : base;
        const prefix = locale.value === 'ar' ? '/ar' : '';
        const full = prefix + path + sub;
        return full === '' ? '/' : full;
    }

    /** Is the given public route currently active? */
    function isActivePath(key: string, exact = false): boolean {
        const target = localePath(key);
        const current = page.url.split('?')[0].split('#')[0].replace(/\/$/, '') || '/';
        const normalized = target.replace(/\/$/, '') || '/';
        return exact || key === 'home' ? current === normalized : current.startsWith(normalized);
    }

    return { t, tList, tObj, locale, direction, isRtl, localePath, isActivePath };
}
