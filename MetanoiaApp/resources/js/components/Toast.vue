<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

interface ToastItem {
    id: number;
    type: 'success' | 'error';
    message: string;
}

const toasts = ref<ToastItem[]>([]);
let seq = 0;

const dismiss = (id: number) => {
    toasts.value = toasts.value.filter((t) => t.id !== id);
};

const push = (type: 'success' | 'error', message: string) => {
    const id = ++seq;
    toasts.value.push({ id, type, message });
    setTimeout(() => dismiss(id), 5000);
};

const page = usePage();
const flash = () => page.props.flash as { success?: string; error?: string } | undefined;

watch(() => flash()?.success, (m) => m && push('success', m), { immediate: true });
watch(() => flash()?.error, (m) => m && push('error', m), { immediate: true });
</script>

<template>
    <div class="pointer-events-none fixed end-4 top-20 z-[100] flex w-[calc(100%-2rem)] max-w-sm flex-col gap-2">
        <transition-group name="toast">
            <div
                v-for="t in toasts"
                :key="t.id"
                class="pointer-events-auto flex items-start gap-3 rounded-2xl border bg-white px-4 py-3.5 shadow-lg"
                :class="t.type === 'success' ? 'border-emerald-200' : 'border-red-200'"
                role="status"
            >
                <span
                    class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full"
                    :class="t.type === 'success' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600'"
                >
                    <svg v-if="t.type === 'success'" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5" /></svg>
                    <svg v-else class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12" /></svg>
                </span>
                <p class="flex-1 text-sm leading-snug text-brand-navy">{{ t.message }}</p>
                <button class="shrink-0 text-brand-muted transition hover:text-brand-navy" aria-label="Dismiss" @click="dismiss(t.id)">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12" /></svg>
                </button>
            </div>
        </transition-group>
    </div>
</template>

<style scoped>
.toast-enter-active,
.toast-leave-active {
    transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
}
.toast-enter-from {
    opacity: 0;
    transform: translateX(24px);
}
.toast-leave-to {
    opacity: 0;
    transform: translateX(24px);
}
.toast-move {
    transition: transform 0.3s ease;
}
</style>
