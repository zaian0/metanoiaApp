<script setup lang="ts">
interface Props {
    class?: string;
}

defineProps<Props>();
</script>

<template>
    <div class="flex aspect-square size-8 items-center justify-center overflow-hidden rounded-md bg-[#1B499F]">
        <img src="/brand/logo-reversed.png" alt="Metanoia" class="size-8 object-cover" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate font-semibold leading-none">Metanoia</span>
        <span class="truncate text-xs text-muted-foreground">Admin</span>
    </div>
</template>
