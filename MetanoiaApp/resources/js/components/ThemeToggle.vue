<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import { Moon, Sun } from 'lucide-vue-next';
import { computed } from 'vue';

const { appearance, updateAppearance } = useAppearance();

const isDark = computed(() => {
    if (appearance.value === 'dark') return true;
    if (appearance.value === 'light') return false;
    return typeof window !== 'undefined' && window.matchMedia('(prefers-color-scheme: dark)').matches;
});

const toggle = () => updateAppearance(isDark.value ? 'light' : 'dark');
</script>

<template>
    <button
        type="button"
        class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-sidebar-border/70 text-muted-foreground transition hover:bg-sidebar-accent hover:text-foreground"
        :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
        @click="toggle"
    >
        <Sun v-if="isDark" class="h-[18px] w-[18px]" />
        <Moon v-else class="h-[18px] w-[18px]" />
    </button>
</template>
