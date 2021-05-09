<template>
  <div class="wiki-creacion-page">
    <main class="main-container">
      <div class="create-event-container">
        <h2>Crea un nuevo evento</h2>
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
      <span class="container-divider">O</span>
      <div class="add-event-container">
        <h2>Añade preguntas a un evento existente</h2>

        <label class="input" for="codigo">
          <input
            v-model="codigoEvento"
            name="codigo"
            type="text"
            placeholder=" "
          />
          <span class="input-label">Código de evento</span>
        </label>
        <button @click="buscarEvento">Buscar evento</button>
      </div>
    </main>
    <AppPaginatedTable
      v-if="eventoCargado"
      :data="eventosAnyadidos"
      :headerFields="camposHeader"
      :total-pages="Math.ceil(eventosAnyadidos.length / itemsPerPage)"
      :total="eventosAnyadidos.length"
      :perPage="itemsPerPage"
      :currentPage="currentPage"
      @page-changed="onPageChange"
    >
    </AppPaginatedTable>
  </div>
</template>

<script>
import AppSelect from '../AppSelect.vue';
import AppPaginatedTable from '../AppPaginatedTable.vue';

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
      eventosAnyadidos: [],
      nuevaPregunta: {
        enunciado: '',
        r1: '',
        r2: '',
        r3: '',
        r4: '',
        respuestaCorrecta: '',
        tiempoLimite: 0,
        imgLink: '',
      },
      codigoEvento: '',
      eventoCargado: true,
      currentPage: 1,
      itemsPerPage: 5,
      camposHeader: [
        'Enunciado',
        'Respuesta 1',
        'Respuesta 2',
        'Respuesta 3',
        'Respuesta 4',
        'Respuesta correcta',
        'Tiempo límite',
        'Enlace a imagen',
      ],
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
  components: { AppSelect, AppPaginatedTable },
  methods: {
    crearEvento() {
      console.log('Se ha intentado crear el evento', this.dataToSend);
    },
    anyadirEvento(
      enunciado,
      r1,
      r2,
      r3,
      r4,
      respuestaCorrecta,
      timeLimit,
      imgLink
    ) {
      this.eventosAnyadidos.push({
        enunciado,
        r1,
        r2,
        r3,
        r4,
        respuestaCorrecta,
        timeLimit,
        imgLink,
      });
    },
    setData(data, target) {
      console.log('Seteando data: ' + data);
      this.dataToSend[target] = data;
    },
    buscarEvento() {
      // TODO: Buscar evento en la base de datos cuando sea posible
      console.log('Se ha intentado buscar un evento');
    },
    consolear(ev) {
      console.log('Consoleando', ev);
    },
    onPageChange() {
      console.log('Respuesta del paginador');
    },
  },
};
</script>

<style lang="scss" scoped>
$--color-accent: goldenrod;

.main-container {
  display: flex;
  flex-flow: row nowrap;
  flex: 0 0 30vw;
  justify-content: space-evenly;
  background: #eee;
}

.create-event-container {
  background: lightpink;
}

.add-event-container {
  background: lightblue;
}

.container-divider {
  display: flex;
  align-items: center;
}

.input {
  position: relative;

  > input {
    display: block;
    width: 80%;
    border: 3px solid inherit;
    padding: 1rem 0.5rem;
    color: currentColor;
    background: inherit;
    border-radius: 4px;

    &:focus,
    &:not(:placeholder-shown) {
      & + .input-label {
        transform: translate(0.4rem, -76%) scale(1);
        color: $--color-accent;
      }
    }
  }

  .input-label {
    position: absolute;
    left: 0;
    top: 0;
    padding: 6px 4px;
    margin: 9px 4px;
    background: salmon;
    white-space: nowrap;
    transform: translate(0, 0);
    transform-origin: 0, 0;
    transition: transform 120ms ease-in;
    font-weight: bold;
    line-height: 1.2;
    color: #133;
  }
}
</style>
