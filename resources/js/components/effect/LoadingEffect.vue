<script setup lang="ts">
const props = defineProps<{
    loading?: boolean
}>();
</script>
<template>
    <div v-if="props?.loading"
        class="flex items-center justify-center h-20 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <div
            class="px-10 py-2 text-md font-medium leading-none text-center text-blue-800 bg-blue-200 rounded-full animate-pulse dark:bg-blue-900 dark:text-blue-200">
            loading...</div>
    </div>
</template>