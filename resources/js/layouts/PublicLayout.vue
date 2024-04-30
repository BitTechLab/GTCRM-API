<script setup lang="ts">
import { onMounted } from 'vue';
import router from '../router';

onMounted(() => {
  if (window.authData?.user) {
    router.push('/');
  }
});
</script>

<template>
  <div class="flex h-screen overflow-hidden">

    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

      <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
          <router-view></router-view>
        </div>
      </main>

    </div>

  </div>
</template>
