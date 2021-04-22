<template> </template>

<script>
// import Pregunta from './Pregunta.vue';
export default {
  name: 'Evento',
  data() {
    return {};
  },
  props: [
    {
      codigo: { type: Number, required: true },
      area: { type: String, required: true },
      etapa: { type: String, required: true },
      nivel: { type: String, required: true },
      tema: { type: String, required: true },
      fecha: { type: Date, required: true },
      revisado: { type: Boolean, required: true },
      preguntas: { type: Array, required: true },
    },
  ],

  methods: {
    //TODO: Esto probablemente no debería estar aquí
    crearEvento(codigo, area, etapa, nivel, tema, fecha, revisado, preguntas) {
      let evento = {
        codigo,
        area,
        etapa,
        nivel,
        tema,
        fecha,
        revisado,
        preguntas,
      };
      return evento;
    },
  },
  components: {
    // Pregunta,
  },
};
</script>

<style>
/* //TODO: Estilos de cada evento */
</style>
