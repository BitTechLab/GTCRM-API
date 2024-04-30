<script setup lang="ts">
import { ref } from 'vue';

const langs = ref(['en', 'ja']);
</script>

<template>
  <select v-model="$i18n.locale" class="border border-zinc-100">
    <option v-for="(lang, i) in langs" :key="`Lang${i}`" :value="lang">
      {{ lang }}
    </option>
  </select>
</template>