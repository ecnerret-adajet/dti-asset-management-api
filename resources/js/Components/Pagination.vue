<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  links: Array,
});
</script>
<template>
  <div v-if="links.length > 3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <div class="d-flex flex-wrap py-2 mr-3">
      <template v-for="(link, key) in links">
        <div
          v-if="link.url === null"
          :key="key"
          class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
          v-html="link.label"
        />
        <Link
          v-else
          :key="`link-${key}`"
          class="btn btn-sm btn-light-primary mr-2 my-1"
          :class="{ 'active': link.active }"
          :href="link.url"
          v-html="link.label"
        />
      </template>
      </div>
    </div>
  </div>
</template>
