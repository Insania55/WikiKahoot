<template>
  <div class="app-select">
    <form>
      <input
        class="chosen-value"
        type="text"
        value=""
        placeholder="Type to filter"
      />
      <ul class="value-list">
        <li v-for="(option, index) in options" :key="index">
          {{ option.label }}
        </li>
      </ul>
    </form>
  </div>
</template>

<script>
export default {
  name: 'AppSelect',
  props: {
    options: {
      type: Object,
    },
  },
  data() {
    return {};
  },
};
</script>

<style></style>
