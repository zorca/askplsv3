<template>
  <p>
    <img
      v-if="field.thumbnailUrl"
      :src="/storage/field.thumbnailUrl"
      style="object-fit: cover;"
      class="w-8 h-8"
      :class="{ 'rounded-full': field.isAvatar }"
    />
    <span v-else>{{ field.value || '&mdash;' }}</span>
  </p>
</template>

<script>
export default {
  props: ['resourceName', 'field']
};
</script>
