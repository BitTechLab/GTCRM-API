<script setup lang="ts">
import { onMounted, onUpdated } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

const props = defineProps<{
  baseUrl: string,
  links?: any
}>();

onMounted(() => {
  // console.log(props.links);
})

onUpdated(() => {
  // console.log(props.links);
})
</script>

<template>
  <div v-if="props?.links" class="flex flex-col items-center my-10">
    <nav aria-label="Page navigation example">
      <ul class="inline-flex -space-x-px text-sm">
        <li v-for="link in props?.links" :key="link?.url">
          <RouterLink :to="{path: baseUrl, query: {...route.query, page: link?.label}}"
            :class="`flex items-center justify-center ${link?.active ? 'bg-blue-100' : 'bg-white'} px-4 mx-1 h-10 leading-tight text-gray-500 border border-gray rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white`">
            <span v-html="link?.label"></span>
          </RouterLink>
        </li>
      </ul>
    </nav>
  </div>
</template>