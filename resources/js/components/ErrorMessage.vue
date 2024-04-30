<script setup lang="ts">
const props = defineProps<{
    error: any
}>();
</script>
<template>
    <div v-if="props?.error"
        class="p-4 mb-4 text-center text-red rounded-lg bg-orange-200" role="alert">
        <span class="font-bold">Error! </span> {{ props?.error?.response?.data?.message }}
    </div>
</template>