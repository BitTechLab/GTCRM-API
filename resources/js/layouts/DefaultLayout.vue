<script setup lang="ts">
import { onMounted } from 'vue';
import NavbarArea from './NavbarArea.vue';
import SidebarArea from './SidebarArea.vue';
import router from '../router';

onMounted(() => {
  if (!window.authData?.user) {
    router.push('/login');
  }
});
</script>

<template>
  <div class="flex h-screen overflow-hidden">
    <SidebarArea />

    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
      <NavbarArea />

      <main>
        <div class="p-5 sm:ml-64">
          <div class="p-4 border border-white bg-white rounded-lg dark:border-gray-500 mt-14">
            <router-view></router-view>
          </div>
        </div>
      </main>

    </div>

  </div>
</template>
