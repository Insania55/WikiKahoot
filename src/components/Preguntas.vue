<template>
  <div class="wiki-preguntas">
    <!-- <Pregunta
      v-for="(pregunta, index) in preguntas"
      :key="index"
      :enunciado="pregunta.enunciado"
      :class="pregunta.correcta ? 'respuesta-correcta' : ''"
    ></Pregunta> -->
  </div>
</template>

<script>
// import Pregunta from './Pregunta.vue';
export default {
  name: 'Preguntas',
  data() {
    return {};
  },
  props: {
    preguntas: {
      type: Array,
      required: true,
    },
  },
  components: {
    // Pregunta,
  },
};
</script>

<style type="scss" scoped>
.respuesta-correcta {
  color: darkgreen;
}
</style>
