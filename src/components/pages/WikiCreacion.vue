<template>
  <div class="wiki-creacion-page">
    <h2>Creación de evento</h2>
    <form @submit.prevent>
      <AppSelect
        label="Etapa"
        :options="optionsEtapa"
        @input="consolear"
        @selected-value="setData($event, 'etapa')"
        placeholder="Etapa educativa. si procede"
      ></AppSelect>
      <AppSelect
        label="Nivel"
        :options="optionsNivel"
        @input="consolear"
        @selected-value="setData($event, 'nivel')"
        placeholder="Nivel de complejidad"
      ></AppSelect>
      <AppSelect
        label="Área"
        :options="optionsArea"
        @input="consolear"
        @selected-value="setData($event, 'area')"
        placeholder="Área temática general"
      ></AppSelect>
      <AppSelect
        label="Tema"
        :options="optionsTema"
        @selected-value="setData($event, 'tema')"
        @input="consolear"
        placeholder="Tema concreto de la pregunta"
      ></AppSelect>
      <button @click="crearEvento">Crear evento</button>
    </form>
  </div>
</template>

<script>
import AppSelect from '../AppSelect.vue';

export default {
  name: 'WikiCreacion',
  data() {
    return {
      dataToSend: {
        etapa: '',
        nivel: '',
        area: '',
        tema: '',
      },
      optionsEtapa: [
        {
          name: 'Primaria',
          value: 'primaria',
        },
        {
          name: 'Secundaria',
          value: 'secundaria',
        },
        {
          name: 'Bachiller',
          value: 'bachiller',
        },
      ],
      optionsNivel: [
        {
          name: 'Fácil',
          value: 'facil',
        },
        {
          name: 'Intermedio',
          value: 'intermedio',
        },
        {
          name: 'Difícil',
          value: 'dificil',
        },
      ],
      optionsArea: [
        {
          name: 'Anime',
          value: 'anime',
        },
        {
          name: 'Historia',
          value: 'historia',
        },
        {
          name: 'Furbo',
          value: 'furbo',
        },
      ],
      optionsTema: [
        {
          name: 'Gormiti',
          value: 'gormiti',
        },
        {
          name: '2ª Guerra Mundial',
          value: 'segunda guerra mundial',
        },
        {
          name: 'Barça',
          value: 'barça',
        },
      ],
    };
  },
  components: { AppSelect },
  methods: {
    crearEvento() {
      console.log('Se ha intentado crear el evento', this.dataToSend);
    },
    setData(data, target) {
      console.log('Seteando data: ' + data);
      this.dataToSend[target] = data;
    },
    consolear(ev) {
      console.log('Consoleando', ev);
    },
  },
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
