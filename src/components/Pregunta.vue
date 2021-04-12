<template>
  <div class="pregunta">
    <p>{{ enunciado }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  props: {
    enunciado: {
      type: String,
      required: true,
    },
    correcta: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style type="scss">
/* //TODO: Estilos para cada pregunta */
</style>
