<template>
  <div class="wiki-creacion-page">
    <h2>Work in progress</h2>
  </div>
</template>

<script>
export default {
  name: 'WikiCreacion',
  data() {
    return {};
  },
  components: {},
};
</script>

<style lang="scss" scoped>
$--color-accent: goldenrod;

.input {
  position: relative;

  .input-label {
    position: absolute;
    left: 0;
    top: 0;
    padding: 6px 4px;
    margin: 9px 4px;
    // background: $--color-filter-container;
    white-space: nowrap;
    transform: translate(0, 0);
    transform-origin: 0, 0;
    transition: transform 120ms ease-in;
    font-weight: bold;
    line-height: 1.2;
    color: #133;
  }

  > input {
    display: block;
    width: 80%;
    // border: 3px solid $--color-dark-font;
    padding: 1rem 0.5rem;
    color: currentColor;
    // background: $--color-filter-container;
    border-radius: 4px;

    &:focus,
    &:not(:placeholder-shown) {
      & + .input-label {
        transform: translate(0.4rem, -76%) scale(1);
        color: $--color-accent;
      }
    }
  }
}
</style>
